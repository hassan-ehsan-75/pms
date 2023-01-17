<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	//for the admin default credintals
        DB::table('users')->insert([
        	'user_id'=>1,
        	'user_name'=>'Admin',
            'email'=>'admin@admin.com',
        	'password'=>Hash::make('admin'), 
        	'full_name'=>'admin', 
        	'other'=>'',
            'activated'=>1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
 
        	]);
        //deleted user
         DB::table('users')->insert([
            'user_id'=>2,
            'user_name'=>'nasable_user',
            'email'=>'deleted_user@nasable.com',
            'password'=>Hash::make('nasabeluser'), 
            'full_name'=>'nasabel User', 
            'other'=>'',
            'activated'=>1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
 
            ]);
        //seed with titles for roles
        DB::table('titles')->insert([
            ['title_name'=>'Admin','created_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['title_name'=>'Developer','created_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['title_name'=>'Chief Executive Officer (CEO)','created_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['title_name'=>'Chief Technology Officer (CTO)','created_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['title_name'=>'Front End Developer','created_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['title_name'=>'Back End Developer','created_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['title_name'=>'Systems Administrator','created_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['title_name'=>'Security Specialist','created_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['title_name'=>'Web Developer','created_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['title_name'=>'Android Developer','created_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['title_name'=>'iOS Developer','created_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['title_name'=>'Trainee','created_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['title_name'=>'Intern','created_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['title_name'=>'Social Media Manager','created_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['title_name'=>'Marketing','created_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['title_name'=>'Support','created_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['title_name'=>'Desginer','created_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['title_name'=>'Manager','created_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['title_name'=>'Co-founder','created_at' => Carbon::now()->format('Y-m-d H:i:s')]

        	]);
        //seed user title for the admin
        Db::table('user_titles')->insert([
            'user_id'=>1,
            'title_id'=>1,
             'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);

         Db::table('permissions')->insert([
            ['permission_name'=>'Admin'],
            ['permission_name'=>'User'],
            ['permission_name'=>'Guest'],
            ['permission_name'=>'Manager']
        ]);
        
        Db::table('user_permissions')->insert([
            'user_id'=>1,
            'permission_id'=>1
        ]);

    }
}
