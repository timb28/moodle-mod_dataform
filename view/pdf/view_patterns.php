<?php
// This file is part of Moodle - http://moodle.org/.
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle. If not, see <http://www.gnu.org/licenses/>.

/**
 * @package dataformview
 * @subpackage pdf
 * @copyright 2012 Itamar Tzadok
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') or die;

require_once("$CFG->dirroot/mod/dataform/view/view_patterns.php");

/**
 * Base class for view patterns
 */
class mod_dataform_view_pdf_patterns extends mod_dataform_view_patterns{

    /**
     *
     */
    public function get_replacements($tags = null, $entry = null, array $options = array()) {
        global $CFG, $OUTPUT;

        $replacements = parent::get_replacements($tags, $entry, $options);
        
        $view = $this->_view;
        $df = $view->get_df();
        $filter = $view->get_filter();
        $baseurl = new moodle_url($view->get_baseurl());
        $baseurl->param('sesskey', sesskey());

        foreach ($tags as $tag) {
            switch ($tag) {
                case '##export:all##':
                    $actionurl = new moodle_url($baseurl, array('exportpdf' => $view::EXPORT_ALL));
                    //$label = $OUTPUT->pix_icon('f/pdf', get_string('multiexport', 'dataform'));
                    $label = html_writer::tag('span', get_string('exportall', 'dataform'));
                    $replacements[$tag] = html_writer::link($actionurl, $label, array('class' => 'actionlink exportall'));

                    break;
                case '##export:page##':
                    $actionurl = new moodle_url($baseurl, array('exportPDF' => $view::EXPORT_PAGE));
                    //$label = $OUTPUT->pix_icon('f/pdf', get_string('multiexport', 'dataform'));
                    $label = html_writer::tag('span', get_string('exportpage', 'dataform'));
                    $replacements[$tag] = html_writer::link($actionurl, $label, array('class' => 'actionlink exportpage'));

                    break;
                case '##pagebreak##':
                    $replacements[$tag] = $view::PAGE_BREAK;

                    break;
            }
        }

        return $replacements;
    }

    /**
     *
     */
    protected function patterns() {
        $patterns = parent::patterns();
        $cat = get_string('pluginname', 'dataformview_pdf');
        $patterns['##export:all##'] = array(true, $cat);
        $patterns['##export:page##'] =  array(true, $cat);
        $patterns['##pagebreak##'] =  array(true, $cat);

        return $patterns;
    }
}
