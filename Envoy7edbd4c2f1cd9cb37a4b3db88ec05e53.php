<?php $seed = isset($seed) ? $seed : null; ?>
<?php $project_root = isset($project_root) ? $project_root : null; ?>
<?php $project_url = isset($project_url) ? $project_url : null; ?>
<?php $project_name = isset($project_name) ? $project_name : null; ?>
<?php $to = isset($to) ? $to : null; ?>

<?php $__container->servers(['ketofiregummies'  => 'root@67.227.154.220','localhost' => '127.0.0.1']); ?>

<?php
if($to == 'ketofiregummies') {
$project_name = 'ketofiregummies';
$project_url = 'https://www.ketofiregummies.com/';
$project_root = '/home/ketofiregummies/www/';
} else {
echo "Must select  '--to=ketofiregummies' ".PHP_EOL.PHP_EOL;
die();
}
?>

<?php $__container->startTask('put_app_up', ['on' => $to]); ?>
cd <?php echo $project_root; ?>


<?php /* php artisan up */ ?>
<?php $__container->endTask(); ?>

<?php $__container->startTask('put_app_down', ['on' => $to]); ?>
cd <?php echo $project_root; ?>


<?php /* php artisan down */ ?>
<?php $__container->endTask(); ?>

<?php $__container->startTask('add_key', ['on' => 'localhost']); ?>
sagent
ssh-add /home/vagrant/.ssh/deployketofiregummies
<?php $__container->endTask(); ?>

<?php $__container->startTask('remove_key', ['on' => 'localhost']); ?>
ssh-add -d /home/vagrant/.ssh/deployketofiregummies
<?php $__container->endTask(); ?>

<?php $__container->startTask('pull_latest_changes', ['on' => $to]); ?>
cd <?php echo $project_root; ?>

git reset --hard
<?php /*git pull origin*/ ?>
git pull git@github.com:cachola/ketofiregummies.com.git master
<?php $__container->endTask(); ?>

<?php $__container->startTask('install_dependencies', ['on' => $to]); ?>
cd <?php echo $project_root; ?>


<?php /* composer install */ ?>
<?php $__container->endTask(); ?>

<?php $__container->startTask('seed', ['on' => $to]); ?>
cd <?php echo $project_root; ?>


<?php /* php artisan migrate --force 
php artisan db:seed --force  */ ?>
<?php $__container->endTask(); ?>


<?php $__container->startTask('clear_cache', ['on' => $to]); ?>
cd <?php echo $project_root; ?>


php artisan cache:clear
<?php $__container->endTask(); ?>


<?php $__container->startTask('permissions', ['on' => $to]); ?>
echo Changing permissions on <?php echo $project_root; ?>

chown -R ketofiregummies:ketofiregummies <?php echo $project_root; ?>

chmod -R 755 <?php echo $project_root; ?>


<?php $__container->endTask(); ?>

<?php $__container->startTask('deploy_new', ['on' => $to]); ?>
cd <?php echo $project_root; ?>

git clone git@github.com:cachola/ketofiregummies.com.git new
<?php $__container->endTask(); ?>


<?php $__container->startMacro('deploy_to_new'); ?>
add_key
deploy_new
<?php /* install_dependencies */ ?>
remove_key
<?php /* put_app_up */ ?>
<?php $__container->endMacro(); ?>


<?php $__container->startMacro('quick'); ?>
<?php /*put_app_down */ ?>
add_key
pull_latest_changes
<?php /* install_dependencies */ ?>
permissions
remove_key
<?php /* put_app_up */ ?>
<?php $__container->endMacro(); ?>


<?php $__container->startMacro('update'); ?>
<?php /* }}
<?php if($seed): ?>
seeding
<?php endif; ?>
*/ ?>
version
<?php /* put_app_down */ ?>
pull_latest_changes
<?php /* install_dependencies
seed */ ?>
permissions
<?php /* put_app_up */ ?>
<?php $__container->endMacro(); ?>


<?php /*
<?php $__container->startTask('seeding', ['on' => 'localhost']); ?>
echo "Dumping Voyager parameters\n"
./artisan db:seed
git add database/seeds/Seeders
git ci -am"Added voyager dumps"
echo "Done"
<?php $__container->endTask(); ?>
*/ ?>
<?php $__container->startTask('version', ['on' => 'localhost']); ?>
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
<?php /*npm run production */ ?>
git add .
git ci -am"Updated Revision and packed js code"
git push git@github.com:cachola/ketofiregummies.com.git master

<?php $__container->endTask(); ?>

<?php $__container->startTask('rsync', ['on' => 'localhost']); ?>
rsync -vr  --exclude-from=./excludesFile ./* root@67.227.154.220:/home/ketofiregummies/public_html/
<?php $__container->endTask(); ?>
<?php $__container->startMacro('quicksync'); ?>
rsync
permissions
<?php $__container->endMacro(); ?>


<?php $__container->startTask('test'); ?>
echo <?php echo $project_name; ?>

<?php $__container->endTask(); ?>
