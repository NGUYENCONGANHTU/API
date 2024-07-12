<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder
{
     /**
     * Create the initial roles and permissions.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Create permissions
         */
        $permissions = [
            //admin 
            ['name' => 'super-admin-index', 'guard_name' => 'admin-api'],
            ['name' => 'super-admin-show', 'guard_name' => 'admin-api'],
            ['name' => 'super-admin-store', 'guard_name' => 'admin-api'],
            ['name' => 'super-admin-update', 'guard_name' => 'admin-api'],
            ['name' => 'super-admin-delete', 'guard_name' => 'admin-api'],
            ['name' => 'super-admin-updateStatus', 'guard_name' => 'admin-api'],
            // banner
            ['name' => 'banner-index', 'guard_name' => 'admin-api'],
            ['name' => 'banner-show', 'guard_name' => 'admin-api'],
            ['name' => 'banner-store', 'guard_name' => 'admin-api'],
            ['name' => 'banner-update', 'guard_name' => 'admin-api'],
            ['name' => 'banner-destroy', 'guard_name' => 'admin-api'],
            // category
            ['name' => 'category-index', 'guard_name' => 'admin-api'],
            ['name' => 'category-show', 'guard_name' => 'admin-api'],
            ['name' => 'category-store', 'guard_name' => 'admin-api'],
            ['name' => 'category-update', 'guard_name' => 'admin-api'],
            ['name' => 'category-destroy', 'guard_name' => 'admin-api'],
            // trademark
            ['name' => 'trademark-index', 'guard_name' => 'admin-api'],
            ['name' => 'trademark-show', 'guard_name' => 'admin-api'],
            ['name' => 'trademark-store', 'guard_name' => 'admin-api'],
            ['name' => 'trademark-update', 'guard_name' => 'admin-api'],
            ['name' => 'trademark-destroy', 'guard_name' => 'admin-api'],
            // news
            ['name' => 'news-index', 'guard_name' => 'admin-api'],
            ['name' => 'news-show', 'guard_name' => 'admin-api'],
            ['name' => 'news-store', 'guard_name' => 'admin-api'],
            ['name' => 'news-update', 'guard_name' => 'admin-api'],
            ['name' => 'news-destroy', 'guard_name' => 'admin-api'],
            // product-attribute
            ['name' => 'product-attribute-index', 'guard_name' => 'admin-api'],
            ['name' => 'product-attribute-show', 'guard_name' => 'admin-api'],
            ['name' => 'product-attribute-store', 'guard_name' => 'admin-api'],
            ['name' => 'product-attribute-update', 'guard_name' => 'admin-api'],
            ['name' => 'product-attribute-destroy', 'guard_name' => 'admin-api'],
            // product-image
            ['name' => 'product-image-index', 'guard_name' => 'admin-api'],
            ['name' => 'product-image-show', 'guard_name' => 'admin-api'],
            ['name' => 'product-image-store', 'guard_name' => 'admin-api'],
            ['name' => 'product-image-update', 'guard_name' => 'admin-api'],
            ['name' => 'product-image-destroy', 'guard_name' => 'admin-api'],
            // product
            ['name' => 'product-index', 'guard_name' => 'admin-api'],
            ['name' => 'product-show', 'guard_name' => 'admin-api'],
            ['name' => 'product-store', 'guard_name' => 'admin-api'],
            ['name' => 'product-update', 'guard_name' => 'admin-api'],
            ['name' => 'product-destroy', 'guard_name' => 'admin-api'],
            //
            ['name' => 'attribute-index', 'guard_name' => 'admin-api'],
            ['name' => 'attribute-show', 'guard_name' => 'admin-api'],
            ['name' => 'attribute-store', 'guard_name' => 'admin-api'],
            ['name' => 'attribute-update', 'guard_name' => 'admin-api'],
            ['name' => 'attribute-destroy', 'guard_name' => 'admin-api'],
            //
            ['name' => 'contact-index', 'guard_name' => 'admin-api'],
            ['name' => 'contact-show', 'guard_name' => 'admin-api'],
            ['name' => 'contact-store', 'guard_name' => 'admin-api'],
            ['name' => 'contact-update', 'guard_name' => 'admin-api'],
            ['name' => 'contact-destroy', 'guard_name' => 'admin-api'],

            //tuan anh
            ['name' => 'user-index', 'guard_name' => 'admin-api'],
            ['name' => 'user-show', 'guard_name' => 'admin-api'],

            // product-review 
            ['name' => 'productReview-index', 'guard_name' => 'admin-api'],
            ['name' => 'productReview-show', 'guard_name' => 'admin-api'],
 
            // order
            ['name' => 'order-index', 'guard_name' => 'admin-api'],

            //order-detail
            ['name' => 'orderDetail-show', 'guard_name' => 'admin-api'],
        ];
        
        foreach ($permissions as $permissions) {
            Permission::create($permissions);
        }

        /**
         * create ROLE 
         */
        $roleAdmin = Role::create(
            [   'name' => 'admin',
                'guard_name' => 'admin-api'
            ]
        );
        $roleSuperAdmin = Role::create(
            [   'name' => 'super-admin',
                'guard_name' => 'admin-api'
            ]
        );

        /**
         * Assign permissions to roles Admin
         */
        $roleAdmin->givePermissionTo([
            'super-admin-index',
            'super-admin-show',
            'banner-index',
            'banner-show',
            'category-index',
            'category-show',
            'trademark-index',
            'trademark-show',
            'news-index',
            'news-show',
            'product-index',
            'product-show',
            'attribute-index',
            'attribute-show',
            'contact-index',
            'contact-show',
            'user-index',
            'user-show',
            'productReview-index',
            'productReview-show',
            'order-index',
            

        ]);
        
        /**
         * Get a list of all permissions
         */
        $allPermissions = Permission::pluck('name')->toArray();
         /**
         * Assign permissions to roles SuperAdmin
         */
        $roleSuperAdmin->givePermissionTo($allPermissions);
    }
}