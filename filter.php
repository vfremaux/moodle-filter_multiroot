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

        // Bring back any alias to the current wwwroot.

        $aliasesdomains = preg_split('/[\s,]+/', $CFG->allowmultirootdomains);
        preg_match('#^https?\\://(.*)#', $CFG->wwwroot, $matches);
        $protocol = $matches[0];
        foreach ($aliasesdomains as $d) {
            // Avoid changing self...
            if ($d != $matches[1]) {
                $text = preg_replace("#{$protocol}{$d}#", $CFG->wwwroot, $text);
            }
        }

        return $text;
    }
}

