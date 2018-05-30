<?php
namespace Smart2be\IcoAdvice\Classes;

use \Backend\Widgets\Form as oldForm;

class Form extends oldForm {

	public function render($options = [])
    {
        if (isset($options['preview'])) {
            $this->previewMode = $options['preview'];
        }
        if (!isset($options['useContainer'])) {
            $options['useContainer'] = true;
        }
        if (!isset($options['section'])) {
            $options['section'] = null;
        }

        $extraVars = [];
        $targetPartial = 'form';

        /*
         * Determine the partial to use based on the supplied section option
         */
        if ($section = $options['section']) {
            $section = strtolower($section);

            if (isset($this->allTabs->{$section})) {
                $extraVars['tabs'] = $this->allTabs->{$section};
            }

            $targetPartial = 'section';
            $extraVars['renderSection'] = $section;
        }

        /*
         * Apply a container to the element
         */
        if ($useContainer = $options['useContainer']) {
            $targetPartial = $section ? 'section-container' : 'form-container1';
        }

        $this->prepareVars();

        /*
         * Force preview mode on all widgets
         */
        if ($this->previewMode) {
            foreach ($this->formWidgets as $widget) {
                $widget->previewMode = $this->previewMode;
            }
        }

        return $this->makePartial($targetPartial, $extraVars);
    }


}