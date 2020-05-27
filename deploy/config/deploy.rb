# config valid for current version and patch releases of Capistrano
lock "~> 3.13.0"

set :application, 'ePolka'
set :repo_url, 'git@github.com:vlyagusha/epolka.git'

# Default branch is :master
set :branch, 'master'

# Default deploy_to directory is /var/www/my_app_name
set :deploy_to, '/home/vlyagusha/www/epolka'

# Default value for :format is :airbrussh.
# set :format, :airbrussh

# You can configure the Airbrussh format using :format_options.
# These are the defaults.
# set :format_options, command_output: true, log_file: "log/capistrano.log", color: :auto, truncate: :auto

# Default value for :pty is false
# set :pty, true

# Default value for :linked_files is []
append :linked_files, '.env'

# Default value for linked_dirs is []
append :linked_dirs, 'var'

# Default value for default_env is {}
# set :default_env, { path: "/opt/ruby/bin:$PATH" }

# Default value for local_user is ENV['USER']
# set :local_user, -> { `git config user.name`.chomp }

# Default value for keep_releases is 5
set :keep_releases, 5

# Uncomment the following to require manually verifying the host key before first deploy.
# set :ssh_options, verify_host_key: :secure

append :copy_files, 'vendor'

namespace :crontab do
    desc 'Install crontab'
    task :install do
        on roles(:cron) do |server|
            crontab_file = "crontab/crontab.erb"

            template = ERB.new(File.new(crontab_file).read).result(binding)
            execute :echo, Shellwords.escape(template.force_encoding('binary')), '|', :crontab, '-'
        end
    end

    desc 'Clear crontab'
    task :clear do
        on roles(:cron) do
            execute :crontab, '-r', raise_on_non_zero_exit: false
        end
    end
end

namespace :cache do
  task :clear do
    on roles(:web) do
      within release_path do
        execute "bin/console", "cache:clear"
      end
    end
  end

  task :warmup do
      on roles(:web) do
        within release_path do
          execute "bin/console", "cache:warmup"
        end
      end
    end
end

namespace :migrations do
  task :migrate do
    on roles(:db) do
      within release_path do
        execute "bin/console", "doctrine:migrations:migrate", "--no-interaction"
      end
    end
  end
end

namespace :fpm do
  task :restart do
    on roles(:web) do
      within release_path do
        execute "sudo", "service", "php7.4-fpm", "restart"
      end
    end
  end
end

namespace :deploy do
  before :cleanup, 'migrations:migrate'
  before :cleanup, 'cache:clear'
  before :cleanup, 'cache:warmup'
  before :cleanup, 'crontab:clear'
  after :cleanup, 'crontab:install'
  after :finishing, 'fpm:restart'
end
