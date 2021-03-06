<?php

namespace CyberDuck\BlockPage\Admin;

use CyberDuck\BlockPage\Action\GridFieldVersionedContentBlockItemRequest;
use SilverStripe\Admin\ModelAdmin;
use SilverStripe\Forms\GridField\GridFieldDetailForm;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

class BlockAdmin extends ModelAdmin
{
    public function getEditForm($id = null, $fields = null)
    {
        $form = parent::getEditForm($id, $fields);
        $form
            ->Fields()
            ->fieldByName($this->sanitiseClassName($this->modelClass))
            ->getConfig()
            ->removeComponentsByType(GridFieldOrderableRows::class)
            ->getComponentByType(GridFieldDetailForm::class)
            ->setItemRequestClass(GridFieldVersionedContentBlockItemRequest::class);

        return $form;
    }

    public function getList()
    {
        $list = parent::getList();
        $requestFilters = $this->getRequest()->requestVar('filter');
        $filters = [];
        if (isset($requestFilters['CyberDuck-BlockPage-Model-ContentBlock']['ClassName']) and ! empty($requestFilters['CyberDuck-BlockPage-Model-ContentBlock']['ClassName'])) {
            $filters['ClassName'] = $requestFilters['CyberDuck-BlockPage-Model-ContentBlock']['ClassName'];
        }

        return $list->filter($filters);
    }
}
