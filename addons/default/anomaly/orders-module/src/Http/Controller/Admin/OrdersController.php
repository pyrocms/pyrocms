<?php namespace Anomaly\OrdersModule\Http\Controller\Admin;

use Anomaly\OrdersModule\Order\Form\OrderFormBuilder;
use Anomaly\OrdersModule\Order\Table\OrderTableBuilder;
use Anomaly\Streams\Platform\Http\Controller\AdminController;

class OrdersController extends AdminController
{

    /**
     * Display an index of existing entries.
     *
     * @param OrderTableBuilder $table
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(OrderTableBuilder $table)
    {
        return $table->render();
    }

    /**
     * Create a new entry.
     *
     * @param OrderFormBuilder $form
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function create(OrderFormBuilder $form)
    {
        return $form->render();
    }

    /**
     * Edit an existing entry.
     *
     * @param OrderFormBuilder $form
     * @param        $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(OrderFormBuilder $form, $id)
    {
        return $form->render($id);
    }
}
