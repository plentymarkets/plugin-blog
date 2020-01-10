<?php

namespace Blog\Assistants\DuplicatedPosts\SettingsHandler;

use Exception;
use Plenty\Modules\Wizard\Contracts\WizardSettingsHandler;

/**
 * Class DuplicatedPostsSettingsHandler
 * @package Blog\Assistants\DuplicatedPosts\SettingsHandler
 */
class DuplicatedPostsSettingsHandler implements WizardSettingsHandler
{
    /**
     * @param array $parameters
     * @return mixed
     * @throws Exception
     */
    public function handle(array $parameters)
    {
        return true;
    }
}
