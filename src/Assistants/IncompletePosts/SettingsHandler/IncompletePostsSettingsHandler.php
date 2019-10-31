<?php

namespace Blog\Assistants\IncompletePosts\SettingsHandler;

use Plenty\Modules\Wizard\Contracts\WizardSettingsHandler;

/**
 * Class IncompletePostsSettingsHandler
 * @package Blog\Assistants\IncompletePosts\SettingsHandler
 */
class IncompletePostsSettingsHandler implements WizardSettingsHandler
{
    /**
     * @param array $parameters
     * @return mixed
     * @throws \Exception
     */
    public function handle(array $parameters)
    {
        return true;
    }
}
