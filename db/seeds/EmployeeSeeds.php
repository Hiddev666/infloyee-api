<?php


use Phinx\Seed\AbstractSeed;

class EmployeeSeeds extends AbstractSeed
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
                'nrp' => '12275',
                'nama' => 'Wahid Abdul Aziz',
                'jabatan' => 'Back End Developer',
                'tanggal_lahir' => '2007-08-30',
                'alamat' => 'Los Angeles',
                'email' => 'wahid@gmail.com',
                'no_telepon' => '087893244576',
                'role' => 'user',
                'id_departemen' => '1',
                'avatar' => 'localhost/images/323294372_182810657683099_4409370124522607977_n.jpg',
                'password' => '123'
            ],
            [
                'nrp' => '12345',
                'nama' => 'Lorem Ipsum',
                'jabatan' => 'Asisten Manajer',
                'tanggal_lahir' => '1998-08-30',
                'alamat' => 'San Diego',
                'email' => 'lorem@gmail.com',
                'no_telepon' => '087893244532',
                'role' => 'admin',
                'id_departemen' => '2',
                'avatar' => 'localhost/images/323294372_182810657683099_4409370124522607977_n.jpg',
                'password' => 'admin'
            ]
        ];

        $employee = $this->table('employees');
        $employee->insert($data)->save();

    }
}
