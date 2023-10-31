<?php declare(strict_types=1);

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Presenter;
use Nette\Application\UI\Form;

final class AdminPresenter extends Presenter
{
    public function startup()
    {
        parent::startup();

        if($this->getUser()->isLoggedIn() === false && $this->getAction() !== 'signIn') {
           $this->flashMessage('nejsi přihlášený', 'error');
           $this->redirect('signIn');
        }
    }

    //localhost/admin/sign-in
    public function actionSignIn()
    {
        //$this->setLayout('admin.signIn');
    }
    //localhost/admin/dashboard
    public function actionDashboard()
    {

    }
    //localhost/admin/sign-out
    public function actionSignOut()
    {
        $this->getUser()->logout();
        $this->flashMessage('odhlášení proběhlo úspěšně');
        $this->redirect('Home:');
    }

    protected function createComponentSignInForm(): Form
    {
        $form = new Form();
        $form->addText('username', 'Username');
        $form->addPassword('password','Password');
        $form->addSubmit('send','Sign In');
        $form->onSuccess[] = [$this, 'signInFormSuccess'];

        return $form;
    }

    public function signInFormSuccess(Form $form)
    {
        $values = $form->getValues();
        try {
            $this->getUser()->login($values->username, $values->password);
        } catch (Nette\Security\AuthenticationException $e) {
            $this->flashMessage($e->getMessage(), 'error');
            $this->redirect('signIn');
        }

        $this->flashMessage('byl jste úspěšně přihlášen :)');
        $this->redirect('dashboard');
    }
}
