<?php

namespace App\Traits;

trait AutoTableName
{
    public function getTable()
    {
        $key = class_basename($this);

        // Pastikan $tables adalah array
        $tables = config('tables', []);
        if (!is_array($tables)) {
            $tables = [];
        }

        // Langsung kembalikan jika ada key yang persis sama
        if (isset($tables[$key])) {
            return $tables[$key];
        }

        // Coba case-insensitive match
        foreach ($tables as $k => $v) {
            if (strcasecmp($k, $key) === 0) {
                return $v;
            }
        }

        // Kalau tidak ketemu, pakai default dari parent
        return parent::getTable();
    }
}
