<?php namespace Anomaly\ExampleModule\Http\Controller\Admin;

use Anomaly\ExampleModule\Widget\Form\WidgetFormBuilder;
use Anomaly\ExampleModule\Widget\Table\WidgetTableBuilder;
use Anomaly\Streams\Platform\Http\Controller\AdminController;

class WidgetsController extends AdminController
{

    /**
     * Display an index of existing entries.
     *
     * @param WidgetTableBuilder $table
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(WidgetTableBuilder $table)
    {
        return $table->render();
    }

    /**
     * Create a new entry.
     *
     * @param WidgetFormBuilder $form
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function create(WidgetFormBuilder $form)
    {
        return $form->render();
    }

    /**
     * Edit an existing entry.
     *
     * @param WidgetFormBuilder $form
     * @param        $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(WidgetFormBuilder $form, $id)
    {
        return $form->render($id);
    }
}
