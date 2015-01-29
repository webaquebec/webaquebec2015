set :application, 'webaquebec2015'
set :repo_url, 'git@github.com:webaquebec/webaquebec2015.git'

# Thoses options are for the WP-CLI. if you use it, uncomment the related line in the Capfile
#
# Url of the Wordpress root installation on the REMOTE server
# (used by search-replace command).
# set :wpcli_remote_url, "http://dev.waq.o2web.biz"

# Url of the Wordpress root installation on the LOCAL server
# (used by search-replace command).
set :wpcli_local_url, "http://localhost:8888"

# You can pass arguments directly to WPCLI using this var.
# By default it will try to load values from ENV['WPCLI_ARGS'].
#set :wpcli_args

# Branch options
# Prompts for the branch name (defaults to current branch)
#ask :branch, proc { `git rev-parse --abbrev-ref HEAD`.chomp }

# Sets branch to current one
#set :branch, proc { `git rev-parse --abbrev-ref HEAD`.chomp }

# Hardcodes branch to always be master
# This could be overridden in a stage config file
set :branch, :master

# Set the default deploy path to use different folders for different environments
set :deploy_to, -> { "/#{fetch(:home, 'home')}/#{fetch(:username)}/#{fetch(:application)}/#{fetch(:stage)}" }
set :home_folder, -> { "/#{fetch(:home, 'home')}/#{fetch(:username)}/" }
set :tmp_dir, -> { "/#{fetch(:home, 'home')}/#{fetch(:username)}/tmp" }

# Set the default symlink folders to symlink after the deployment cycle is done.
set :bedrock_staging_symlink, 'dev'
set :bedrock_production_symlink, 'public_html'

# Use :debug for more verbose output when troubleshooting
set :log_level, :debug

# Apache users with .htaccess files:
# it needs to be added to linked_files so it persists across deploys:
# set :linked_files, fetch(:linked_files, []).push('.env', 'web/.htaccess')
set :linked_files, fetch(:linked_files, []).push('.env', 'web/.htaccess')
set :linked_dirs, fetch(:linked_dirs, []).push('web/app/uploads')

set :pty, true

namespace :deploy do
  desc "Link the code folder to the webserver folder"
  task :link_release_to_public do
    on roles(:app) do
      within "#{fetch(:home_folder)}" do
        if fetch(:stage) == :staging
          info " Symlinking to Staging"
          execute "rm -rf #{fetch(:bedrock_staging_symlink)} && ln -sf #{current_path}/web #{fetch(:bedrock_staging_symlink)}"
        else
          info " Symlinking to Production"
          execute "rm -rf #{fetch(:bedrock_production_symlink)} && ln -sf #{current_path}/web #{fetch(:bedrock_production_symlink)}"
        end
      end
    end
  end
end

namespace :uploads do
  desc "Syncs uploads directory from local to remote"
  task :sync do
    invoke "uploads:pull"
    invoke "uploads:push"
  end

  desc "Pull the uploads folder from the server"
  task :pull do
    run_locally do
      roles(:all).each do |role|
        execute :rsync, "-avzO -e 'ssh -p #{fetch(:ssh_options).fetch(:port, 22)}' --exclude='.DS_Store' #{role.user}@#{role.hostname}:#{shared_path}/web/app/uploads/ web/app/uploads/"
      end
    end
  end

  desc "Push the uploads folder to the server"
  task :push do
    run_locally do
      roles(:all).each do |role|
        execute :rsync, "-avzO -e 'ssh -p #{fetch(:ssh_options).fetch(:port, 22)}' --exclude='.DS_Store' web/app/uploads/ #{role.user}@#{role.hostname}:#{shared_path}/web/app/uploads/"
      end
    end
  end
end

namespace :predeploy do

  desc "Check if the google analytic code is present"
  task :check_google_analytics do
    run_locally do
      footer = Dir['web/app/themes/*/footer.php']
      if fetch(:stage) == :production && !footer.empty?
        if File.readlines(footer.first).grep(/UA-XXXXXXXX-XX/).any?
          error "Trying to deploy to production and Google Analytic code is not set. Code was searched in #{footer.first}"
          exit 1
        else
          info " Google Analytic code found. Good to go."
        end
      end
    end
  end
end

# The above restart task is not run by default
# Uncomment the following line to run it on deploys if needed
before 'deploy:check', 'predeploy:check_google_analytics'
after 'deploy:publishing', 'deploy:link_release_to_public'
