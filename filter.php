<?php
// This file is part of Moodle - http://moodle.org/
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
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * @package     filter_multiroot
 * @category    filter
 * @author      valery.fremaux <valery.fremaux@gmail.com>
 * @copyright   2010 onwards Valery Fremaux (http://www.mylearningfactory.com)
 */
defined('MOODLE_INTERNAL') || die();

class filter_multiroot extends moodle_text_filter {

    public function filter($text, array $options = array()) {
        global $CFG, $CFG;

        if (empty($CFG->multiroot)) {
            return $text;
        }

        if (isset($CFG->originalwwwroot) && $CFG->originalwwwroot != $CFG->wwwroot) {
            // If we are in an alias, translate orignal contents to current alias.
            $text = preg_replace("#{$CFG->originalwwwroot}#", $CFG->wwwroot, $text);
        } else {
            /*
             * if we are in the original domain, bring back all aliases to the original domain when displaying.
             * Brings back all Alias1, Alias2, AliasN contents to Original
             * this will not solve all crossover situations, specially for content created on Alias1 and
             * accessed through Alias2
             */
            if (!empty($CFG->hosts_themes)) {
                $hostdomains = implode('|', array_keys($CFG->hosts_themes));
            }
            $text = preg_replace("#http://{$hostdomains}#", $CFG->originalwwwroot, $text);
        }

        return $text;
    }
}

