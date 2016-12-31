<?php

assert_options(ASSERT_ACTIVE, 1);
assert_options(ASSERT_WARNING, 1);
assert_options(ASSERT_QUIET_EVAL, 0);

// Create a handler function
function my_assert_handler($file, $line, $code, $desc = null)
{
    echo "Assertion failed at $file:$line: $code";
    if ($desc) {
        echo ": $desc";
    }
    echo "\n";
}

class TestFailed extends \BadMethodCallException {}


function test($bool) {
  if (!$bool) throw new TestFailed;
}

// Set up the callback
assert_options(ASSERT_CALLBACK, 'my_assert_handler');
