<?php


use Phinx\Seed\AbstractSeed;

class DepartementsSeeds extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run(): void
    {
        $data = [
            [
                'id_departemen' => '1',
                'nama_departemen' => 'Manajemen Sistem Informasi'
            ],
            [
                'id_departemen' => '2',
                'nama_departemen' => 'SDM'
            ]
        ];

        $departement = $this->table('departements');
        $departement->insert($data)->save();
    }
}
