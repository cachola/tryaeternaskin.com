@servers(['tryaeternaskin'  => '-A root@67.227.154.220','localhost' => '127.0.0.1'])

@setup
if($to == 'tryaeternaskin') {
$project_name = 'tryaeternaskin';
$project_url = 'https://www.tryaeternaskin.com/';
$project_root = '/home/tryaeternaskin/www/';
} else {
echo "Must select  '--to=tryaeternaskin' ".PHP_EOL.PHP_EOL;
die();
}
@endsetup

@task('put_app_up', ['on' => $to])
cd {{ $project_root }}

{{-- php artisan up --}}
@endtask

@task('put_app_down', ['on' => $to])
cd {{ $project_root }}

{{-- php artisan down --}}
@endtask

@task('add_key', ['on' => 'localhost'])
{{-- ssh-add /home/olassalle/.ssh/deploystrongerwithadvancedxr --}}
@endtask

@task('remove_key', ['on' => 'localhost'])
{{-- ssh-add -d /home/olassalle/.ssh/deploystrongerwithadvancedxr --}}
@endtask

@task('pull_latest_changes', ['on' => $to])
cd {{ $project_root }}
git reset --hard
{{--git pull origin--}}
git pull git@github.com:cachola/tryaeternaskin.com.git master
@endtask

@task('install_dependencies', ['on' => $to])
cd {{ $project_root }}

{{-- composer install --}}
@endtask

@task('seed', ['on' => $to])
cd {{ $project_root }}

{{-- php artisan migrate --force
php artisan db:seed --force  --}}
@endtask


@task('clear_cache', ['on' => $to])
cd {{ $project_root }}

php artisan cache:clear
@endtask


@task('permissions', ['on' => $to])
echo Changing permissions on {{$project_root}}
chown -R tryaeternaskin:tryaeternaskin {{ $project_root }}
chmod -R 755 {{ $project_root }}

@endtask




@task('deploy_new', ['on' => $to])
cd {{ $project_root  }}
git clone git@github.com:cachola/tryaeternaskin.com.git newgitclonedir
rsync -av {{ $project_root  }}/newgitclonedir/ {{ $project_root  }}
rm {{ $project_root  }}/newgitclonedir -rf
@endtask


@story('deploy_to_new')
deploy_new
permissions
@endstory

@story('quick')
{{--put_app_down --}}
{{-- add_key --}}
pull_latest_changes
{{-- install_dependencies --}}
permissions
{{-- remove_key --}}
{{-- put_app_up --}}
@endstory


@story('update')
{{-- }}
@if($seed)
seeding
@endif
--}}
version
{{-- put_app_down --}}
pull_latest_changes
{{-- install_dependencies
seed --}}
permissions
{{-- put_app_up --}}
@endstory


{{--
@task('seeding', ['on' => 'localhost'])
echo "Dumping Voyager parameters\n"
./artisan db:seed
git add database/seeds/Seeders
git ci -am"Added voyager dumps"
echo "Done"
@endtask
--}}
@task('version', ['on' => 'localhost'])
echo "-CURRENT- branch pushed to live\n"
SHELL=/bin/bash

if [ `git status --porcelain |wc -l` -ne 0 ]
then
echo "\nUncommited changes exist.\nPlease commit first.\n";
exit 1
fi
bumpversion patch
echo "bumpversion Done"
REVISION=`git rev-parse HEAD`
echo "show revision assign"
echo REVISION
/bin/bash -c echo ${REVISION:0:9} > REVISION
echo "git add step"
git add REVISION
{{--npm run production --}}
git add .
git ci -am"Updated Revision and packed js code"
git push git@github.com:cachola/tryaeternaskin.com.git master

@endtask

@task('rsync', ['on' => 'localhost'])
rsync -vr  ./* root@67.227.154.220:/home/tryaeternaskin/public_html/
@endtask
@story('quicksync')
rsync
permissions
@endstory


@task('test')
echo {{$project_name}}
@endtask
