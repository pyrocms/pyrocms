<?php namespace Anomaly\TvModule\Http\Controller\Admin;

use Anomaly\TvModule\Show\Form\ShowFormBuilder;
use Anomaly\TvModule\Show\Table\ShowTableBuilder;
use Anomaly\Streams\Platform\Http\Controller\AdminController;

class ShowsController extends AdminController
{

    /**
     * Display an index of existing entries.
     *
     * @param ShowTableBuilder $table
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(ShowTableBuilder $table)
    {
        return $table->render();
    }

    /**
     * Create a new entry.
     *
     * @param ShowFormBuilder $form
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function create(ShowFormBuilder $form)
    {
        return $form->render();
    }

    /**
     * Edit an existing entry.
     *
     * @param ShowFormBuilder $form
     * @param        $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(ShowFormBuilder $form, $id)
    {
        return $form->render($id);
    }
}
