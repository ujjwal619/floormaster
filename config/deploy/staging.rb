server '206.189.138.59',
user: 'fms_stage',
roles: %w{web app},
port:22

# Directory to deploy
# ===================
set :env, 'staging'
set :app_debug, 'false'
set :deploy_to, '/home/fms_stage/web'
set :shared_path, '/home/fms_stage/web/shared'
set :overlay_path, '/home/fms_stage/web/overlay'
set :tmp_dir, '/home/fms_stage/web/tmp'
set :site_url, 'http://206.189.138.59'
set :php_fpm, 'php7.2-fpm'
