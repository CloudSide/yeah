Yeah
====

[![Latest Stable Version](https://poser.pugx.org/cloudmario/yeah/v/stable)](https://packagist.org/packages/cloudmario/yeah) [![Total Downloads](https://poser.pugx.org/cloudmario/yeah/downloads)](https://packagist.org/packages/cloudmario/yeah) [![Latest Unstable Version](https://poser.pugx.org/cloudmario/yeah/v/unstable)](https://packagist.org/packages/cloudmario/yeah) [![License](https://poser.pugx.org/cloudmario/yeah/license)](https://packagist.org/packages/cloudmario/yeah)


Execute a command and provides a much greater degree of control over the program execution. 


#### Requirements
* PHP >= 5.3.0

#### Introduction
use composer
composer.json:
```json
"require": {
	"cloudmario/yeah": "dev-master"
}
```

#### Usage

- Simple

```php
$p = new Yeah("/bin/bash");
list($pid, $stdin, $stdout, $stderr) = array($p->pid(), $p->stdin(), $p->stdout(), $p->stderr());

fwrite($stdin, "echo 42.out\n");
fwrite($stdin, "echo 42.err 1>&2\n");
fclose($stdin);

echo "pid    : " . $pid."\n";
echo "stdout : " . trim(fread($stdout, 1024)) . "\n";
echo "stderr : " . trim(fread($stderr, 1024)) . "\n";
echo "status : " . trim(print_r($p->status(), true)) . "\n";
```


- Block

```php
$status = Yeah::yeah("/bin/bash", function($pid, $stdin, $stdout, $stderr) {
	
	fwrite($stdin, "echo 42.out\n");
	fwrite($stdin, "echo 42.err 1>&2\n");
	fclose($stdin);

	echo "pid    : " . $pid . "\n";
	echo "stdout : " . trim(fread($stdout, 1024)) . "\n";
	echo "stderr : " . trim(fread($stderr, 1024)) . "\n";
	
});

echo "status : " . trim(print_r($status, true)) . "\n";
```


[![](http://service.t.sina.com.cn/widget/qmd/1656360925/02781ba4/4.png)](http://weibo.com/smcz)
