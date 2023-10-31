<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use Nette\Database\Table\ActiveRow;
use Nette\Application\AbortException;
use Nette\UnexpectedValueException;
use Ublaboo\DataGrid\DataGrid;
use Ublaboo\DataGrid\Exception\DataGridColumnStatusException;
use Ublaboo\DataGrid\Exception\DataGridException;


final class HomePresenter extends Nette\Application\UI\Presenter
{
    public function __construct(
        private Nette\Database\Explorer $database
    )
    {
        parent::__construct();
    }

    public function actionDefault()
    {
        $this->setLayout('layout');
    }
    public function renderDefault()
    {

    }

    /**
     * @return DataGrid
     * @throws DataGridColumnStatusException
     * @throws DataGridException
     */
    public function createComponentGrid(): DataGrid
    {
        $grid = new DataGrid();

        $grid->setDefaultSort(['id' => 'ASC']);
        $grid->setDataSource($this->database->table('content'));

        $grid->addColumnText('id', 'Id');
        $grid->addColumnText('title', 'Title');
        $grid->addColumnText('author_id', 'Author');
        $grid->addColumnText('status','Status');
        $grid->addColumnText('path', 'Path');

        return $grid;
    }
}
