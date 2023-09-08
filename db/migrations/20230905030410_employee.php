<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Employee extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        $employee = $this->table('employees', ['id' => false, 'primary_key' => ['nrp']]);

        $employee->addColumn('nrp', 'string', ['limit' => 11])
        ->addColumn('nama', 'string', ['limit' => 255])
        ->addColumn('jabatan', 'string', ['limit' => 255])
        ->addColumn('tanggal_lahir', 'date')
        ->addColumn('alamat', 'string', ['limit' => 255])
        ->addColumn('email', 'string', ['limit' => 255])
        ->addColumn('no_telepon', 'string', ['limit' => 255])
        ->addColumn('role', 'string', ['limit' => 6])
        ->addColumn('id_departemen', 'string', ['limit' => 11])
        ->addColumn('avatar', 'text')
        ->addColumn('password', 'string', ['limit' => 50])
                ->create();
    }
}
