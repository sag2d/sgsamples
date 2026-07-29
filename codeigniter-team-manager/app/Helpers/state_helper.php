<?php

use Config\Database;

/**
 * State Helpers
 * 
 * These helpers pull a list of standard states from the database.
 * State results are primarily for building dropdowns, but could have a variety of uses.
 * 
 * @author Scott Greenhagen
 * @version 2.0
 */


/**
 * Get States
 * 
 * This function gets full state names from the database.
 * 
 * @access public
 * @return mixed (Returns the state data if successful, or FALSE if the query failed.)
 */
if (! function_exists('get_states')) {
    function get_states(): array|false
    {
        $rows = Database::connect()
            ->table('states')
            ->select('id, name')
            ->orderBy('name', 'ASC')
            ->get()
            ->getResult();

        if ($rows === []) {
            return false;
        }

        $states = ['' => 'Please Select One'];
        foreach ($rows as $row) {
            $states[$row->id] = $row->name;
        }

        return $states;
    }
}

/**
 * Get State Abbreviations
 * 
 * This function gets state abbreviations from the database.
 * 
 * @access public
 * @return mixed (Returns the state data if successful, or FALSE if the query failed.)
 */
if (! function_exists('get_state_abbrs')) {
    function get_state_abbrs(): array|false
    {
        $rows = Database::connect()
            ->table('states')
            ->select('id, abbr')
            ->orderBy('id', 'ASC')
            ->get()
            ->getResult();

        if ($rows === []) {
            return false;
        }

        $states = ['' => 'Please Select One'];
        foreach ($rows as $row) {
            $states[$row->id] = $row->abbr;
        }

        return $states;
    }
}
