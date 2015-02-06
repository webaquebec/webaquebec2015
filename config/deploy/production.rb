set :stage, :production
set :branch, :master
set :home, 'home3'
set :username, 'webaqueb'

# Simple Role Syntax
# ==================
#role :app, %w{deploy@example.com}
#role :web, %w{deploy@example.com}
#role :db,  %w{deploy@example.com}

# Extended Server Syntax
# ======================
server '66.147.244.160', user: fetch(:username), roles: %w{web app db}
set :wpcli_remote_url, "http://webaquebec.org"

# you can set custom ssh options
# it's possible to pass any option but you need to keep in mind that net/ssh understand limited list of options
# you can see them in [net/ssh documentation](http://net-ssh.github.io/net-ssh/classes/Net/SSH.html#method-c-start)
# set it globally
#  set :ssh_options, {
#    keys: %w(~/.ssh/id_rsa),
#    forward_agent: false,
#    auth_methods: %w(password)
#  }

fetch(:default_env).merge!(wp_env: :production)

# Uncomment the following options if Composer is not installed on the server and you need to user it.
# You will need to install it with "cap production composer::install_executable

# Map the command to the composer installation Path
SSHKit.config.command_map[:composer] = "/usr/php/54/usr/bin/php-cli #{shared_path.join('composer.phar')}"