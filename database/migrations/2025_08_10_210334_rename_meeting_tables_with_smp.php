<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        $tables = [
            'meeting_al_quran'          => 'meeting_al_quran_smp',
            'meeting_bahasa_arab'       => 'meeting_bahasa_arab_smp',
            'meeting_bahasa_ingris'     => 'meeting_bahasa_ingris_smp',
            'meeting_kls_international' => 'meeting_kls_international_smp',
            'meeting_koord_pu'          => 'meeting_koord_pu_smp',
            'meeting_ks_bk'             => 'meeting_ks_bk_smp',
            'meeting_ks_kesiswaan'      => 'meeting_ks_kesiswaan_smp',
            'meeting_ks_kurikulum'      => 'meeting_ks_kurikulum_smp',
            'meeting_manajemen_level'   => 'meeting_manajemen_level_smp',
            'meeting_mata_pelajaran'    => 'meeting_mata_pelajaran_smp',
            'meeting_pks'               => 'meeting_pks_smp',
        ];

        foreach ($tables as $old => $new) {
            if (Schema::hasTable($old) && !Schema::hasTable($new)) {
                Schema::rename($old, $new);
            }
        }
    }

    public function down(): void
    {
        $tables = [
            'meeting_al_quran_smp'          => 'meeting_al_quran',
            'meeting_bahasa_arab_smp'       => 'meeting_bahasa_arab',
            'meeting_bahasa_ingris_smp'     => 'meeting_bahasa_ingris',
            'meeting_kls_international_smp' => 'meeting_kls_international',
            'meeting_koord_pu_smp'          => 'meeting_koord_pu',
            'meeting_ks_bk_smp'             => 'meeting_ks_bk',
            'meeting_ks_kesiswaan_smp'      => 'meeting_ks_kesiswaan',
            'meeting_ks_kurikulum_smp'      => 'meeting_ks_kurikulum',
            'meeting_manajemen_level_smp'   => 'meeting_manajemen_level',
            'meeting_mata_pelajaran_smp'    => 'meeting_mata_pelajaran',
            'meeting_pks_smp'               => 'meeting_pks',
        ];

        foreach ($tables as $old => $new) {
            if (Schema::hasTable($old) && !Schema::hasTable($new)) {
                Schema::rename($old, $new);
            }
        }
    }
};
