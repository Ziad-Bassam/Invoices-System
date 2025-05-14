<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;


class PermissionTableSeeder extends Seeder
{
/**
* Run the database seeds.
*
* @return void
*/
public function run()
{


$permissions = [

        'invoices',
        'list of invoices',
        'paid invoices',
        'Partially paid invoices',
        'unpaid invoices',
        'invoice archive',
        'reports',
        'invoices report',
        'customer report',
        'users',
        'List of users',
        'user permissions',
        'Settings',
        'products',
        'section',
        // 'invoices details',
        // 'Change payment status',


        'Add invoice',
        'Delete invoice',
        // 'Export EXCEL',
        'Change payment status',
        'Edit invoice',
        'Archive the invoice',
        'print invoice',
        'Add attachment',
        'Delete attachment',

        'Add user',
        'Edit User',
        'delete user',

        'View permission',
        'Add permission',
        'Edit permission',
        'Delete permission',

        'Add product',
        'edit product',
        'Delete product',
        
        'Add section',
        'edit section',
        'delete section',
        'notifications',

];



foreach ($permissions as $permission) {

Permission::create(['name' => $permission]);
}


}
}