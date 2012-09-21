
guard 'phpunit', :tests_path => 'tests', :cli => '--colors --bootstrap tests/bootstrap.php --strict --debug --verbose' do
  # Watch test files
  watch(%r{^.+Test\.php$})

  # Watch library files and run their tests
  watch(%r{^core/(.+)\.php}) { |m| "tests/core/#{m[1]}_Test.php" }
end