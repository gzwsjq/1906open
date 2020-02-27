<?php

namespace App\Admin\Controllers;

use App\Model\RegisterModel;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class UserController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'App\Model\RegisterModel';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new RegisterModel());

        $grid->column('id', __('ID'));
        $grid->column('corp', __('公司名称'));
        $grid->column('person', __('法人'));
        $grid->column('scope', __('营业执照'));
        $grid->column('tel', __('联系电话'));
        $grid->column('email', __('Email'));
        $grid->column('address', __('地址'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));
        //$grid->column('pass', __('Pass'));

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(RegisterModel::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('corp', __('Corp'));
        $show->field('person', __('Person'));
        $show->field('scope', __('Scope'));
        $show->field('tel', __('Tel'));
        $show->field('email', __('Email'));
        $show->field('address', __('Address'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('pass', __('Pass'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new RegisterModel());

        $form->text('corp', __('Corp'));
        $form->text('person', __('Person'));
        $form->text('scope', __('Scope'));
        $form->text('tel', __('Tel'));
        $form->email('email', __('Email'));
        $form->text('address', __('Address'));
        $form->text('pass', __('Pass'));

        return $form;
    }
}
