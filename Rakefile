require 'open-uri'

desc "Restore ajax version of schedule"
task :restore_ajax do
  cmd = 'grep -o -r --include="*.html" -E "lazy-load=\"[^\"]+" .'
  lazy_loads = `#{cmd}`
  urls = lazy_loads.split("\n").map { |match| match.split(':').last.split('lazy-load="').last.sub('//webaquebec.org', '') }.uniq
  urls.each { |url| open("http://webaquebec.org#{url}") { |doc| File.write(".#{url}", doc.read) } }
end