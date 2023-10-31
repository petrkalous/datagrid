<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use App\Model\Database\Entity\Content;
use Doctrine\ORM\EntityManagerInterface;
use Ublaboo\DataGrid\DataGrid;
use Ublaboo\DataGrid\DataSource\DoctrineDataSource;
use Ublaboo\DataGrid\Exception\DataGridException;

final class ContentPresenter extends Nette\Application\UI\Presenter
{
    public function __construct(
        private EntityManagerInterface $em,
    )
    {
        parent::__construct();
    }

    public function actionDefault()
    {
        $this->setLayout('content');
    }

    public function renderDefault()
    {

    }

    /**
     * @return DataGrid
     * @throws DataGridException
     */
    public function createComponentContentGrid(): DataGrid
    {
        $grid = new DataGrid();
        $dataSource = $this->em->getRepository(Content::class)
            ->createQueryBuilder('content');

        $source = new DoctrineDataSource($dataSource, 'id');

        //$dataSource2 = $this->database->table('content');
        $grid->setDefaultSort(['order' => 'ASC']);
        $grid->setDataSource($source);

        $grid->addColumnText('id', 'Id:');
        $grid->addColumnText('order', 'order:');
        $grid->addColumnText('title', 'Title:');
        $grid->addColumnText('author_id', 'Author:');
        $grid->addColumnText('status','status:');
        $grid->addColumnDateTime('created_at', 'Created at:');
        $grid->addColumnDateTime('public_at', 'Published at:');
        $grid->setSortable();
        return $grid;

    }
    public function handleSort()
    {
        $repository = $this->em->getRepository(Content::class);
        $item_id = $this->getParameter('item_id');
        $prev_id = $this->getParameter('prev_id');
        $next_id = $this->getParameter('next_id');
        $item = $repository->find($item_id);

        if (!$prev_id) {
            $previousItem = NULL;
        } else {
            $previousItem = $repository->find($prev_id);
        }

        if (!$next_id) {
            $nextItem = NULL;
        } else {
            $nextItem = $repository->find($next_id);
        }

        $itemsToMoveUp = $repository->createQueryBuilder('r')
            ->where('r.order <= :order')
            ->setParameter('order', $previousItem ? $previousItem->getOrder() : 0)
            ->andWhere('r.order > :order2')
            ->setParameter('order2', $item->getOrder())
            ->getQuery()
            ->getResult();

        foreach ($itemsToMoveUp as $t) {
            $t->setOrder($t->getOrder() - 1);
            $this->em->persist($t);
        }
        $itemsToMoveDown = $repository->createQueryBuilder('r')
            ->where('r.order >= :order')
            ->setParameter('order', $nextItem ? $nextItem->getOrder() : 0)
            ->andWhere('r.order < :order2')
            ->setParameter('order2', $item->getOrder())
            ->getQuery()
            ->getResult();

        foreach ($itemsToMoveDown as $t) {
            $t->setOrder($t->getOrder() + 1);
            $this->em->persist($t);
        }

        if ($previousItem) {
            $item->setOrder($previousItem->getOrder() + 1);
        } else if ($nextItem) {
            $item->setOrder($nextItem->getOrder() - 1);
        } else {
            $item->setOrder(1);
        }

        $this->em->persist($item);
        $this->em->flush();

        $this->flashMessage("Id: $item_id, Previous id: $prev_id, Next id: $next_id", 'success');
        $this->redrawControl('flashes');
        $this['contentGrid']->redrawControl();

    }
}
