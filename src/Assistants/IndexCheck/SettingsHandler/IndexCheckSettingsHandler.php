<?php

namespace Blog\Assistants\IndexCheck\SettingsHandler;

use Exception;
use Plenty\Modules\Wizard\Contracts\WizardSettingsHandler;

/**
 * Class IndexCheckSettingsHandler
 * @package Blog\Assistants\IndexCheck\SettingsHandler
 */
class IndexCheckSettingsHandler implements WizardSettingsHandler
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
