<head>
  <script type="text/javascript">
  (function() {
    var link = document.createElement('link');
    link.type = 'image/x-icon';
    link.rel = 'shortcut icon';
    link.href = '../../../h.ico';
    document.getElementsByTagName('head')[0].appendChild(link);
  }());
  </script>
  <link rel="stylesheet" type="text/css" href="../../style.css">
</head>

- [步骤思路](#步骤思路)
- [解析页面](#解析页面)
	- [正则表达式大法](#正则表达式大法)
	- [requests-html](#requestshtml)
	- [BeautifulSoup](#beautifulsoup)
	- [lxml的XPath](#lxml的xpath)
- [模块](#模块)
	- [requests](#requests)
	- [urllib](#urllib)
		- [urllib.request 负责请求](#urllibrequest负责请求)
			- [request()](#request)
			- [urlopen()](#urlopen)
			- [build_opener()](#buildopener)
		- [urllib.error 异常处理模块](#urlliberror异常处理模块)
		- [urllib.parse url 负责解析编码](#urllibparseurl负责解析编码)
			- [转换字符串](#转换字符串)
			- [转换字典](#转换字典)
		- [urllib.robotparser 负责解析robots.txt](#urllibrobotparser负责解析robotstxt)
	- [Beautiful Soup](#beautifulsoup)
- [Selenium](#selenium)
	- [元素定位](#元素定位)
		- [定位方法](#定位方法)
		- [区别](#区别)
	- [判断元素存在](#判断元素存在)
- [转码](#转码)

&nbsp;
&nbsp;
&nbsp;

# 步骤思路

1. 明确目标 (要知道你准备在哪个范围或者网站去搜索)
2. 爬 (将所有的网站的内容全部爬下来)
3. 取 (去掉对我们没用处的数据)
4. 处理数据（按照我们想要的方式存储和使用）
&nbsp;

内容一般分为两部分，**非结构化数据**和**结构化数据**。

**非结构化数据**：先有数据，再有结构

```
1.文本、电话号码、邮箱地址  

　　　　-->正则表达式

2.HTML文件   

　　　　 -->正则表达式，XPath,CSS选择器
```

**结构化数据**：先有结构，再有数据

```
1.JSON文件 

　　　　-->JSON Path

　　　　-->转化成python类型进行操作

2.XML文件

　　　　-->转化成python类型（xmltodict）

　　　　-->XPath

　　　　-->CSS选择器

　　　　-->正则表达式
```



# 解析页面

### 正则表达式大法

正则表达式通常被用来检索、替换那些符合某个模式的文本，所以我们可以利用这个原理来提取我们想要的信息。

正则的好处是编写麻烦，理解不容易，但是匹配效率很高，不过时至今日有太多现成的HTMl内容解析库之后，不太建议再手动用正则来对内容进行匹配了，费时费力。

- 例子：

```
import re

bs1 = re.findall("<h3 class=\"tit\">(.*?)</h3>", str(data))
```



### requests-html

作者高度封装过requests-html，连请求返回内容的编码格式转换也自动做了，完全可以让我的代码逻辑简单直接，更专注于解析工作本身

- 例子：

```
from requests_html import HTMLSession

links = response.html.find('table.olt', first=True).find('a') 
```



### BeautifulSoup

BeautifulSoup解析内容同样需要将请求和解析分开，从代码清晰程度来讲还将就，不过在做复杂的解析时代码略显繁琐

- 例子：

```
from bs4 import BeautifulSoup

bf = BeautifulSoup(data, "html.parser")
pic = bf.find_all('h3', {"class": 'tit'})
pic_bf = BeautifulSoup(str(pic), "html.parser")
img = pic_bf.find_all('a')
```



### lxml的XPath

lxml这个库同时 支持HTML和XML的解析，支持XPath解析方式，解析效率挺高，不过我们需要熟悉它的一些规则语法才能使用

![img](xpath.jpg)

- 例子：

```
from lxml import etree
import lxml.html

content = doc.xpath("//table[@class='olt']/tr/td/a") 
```



# 模块

## requests

Requests 继承了urllib2的所有特性。Requests支持HTTP连接保持和连接池，支持使用cookie保持会话，支持文件上传，支持自动确定响应内容的编码，支持国际化的 URL 和 POST 数据自动编码。

- 例子：添加headers和查询参数

```
# _*_ coding:utf-8 _*_

import requests

kw = {'wd':'python'}
headers = {'User-Agent':'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.101 Safari/537.36'}

# params 接收一个字典或者字符串的查询参数，字典类型自动转换为url编码，不需要urlencode()
response = requests.get("http://www.baidu.com/s?", params = kw, headers = headers)

# 查看响应内容，response.text 返回的是Unicode格式的数据
print response.text

# 查看响应内容，response.content返回的字节流数据
print response.content

# 查看完整url地址
print response.url

# # 查看响应头部字符编码
print response.encoding

# 查看响应码
print response.status_code
```



## urllib

urllib提供了一系列用于操作URL的功能。包含以下四个子模块：

### urllib.request 负责请求

`request`模块提供了最基本的构造 HTTP （或其他协议如 FTP）请求的方法，利用它可以模拟浏览器的一个请求发起过程。

利用不同的协议去获取 URL 信息。它的某些接口能够处理基础认证 （ Basic Authenticaton） 、redirections （HTTP 重定向)、 Cookies (浏览器 Cookies）等情况。而这些接口是由 handlers 和 openers 对象提供的。

#### request()

如果要想模拟浏览器发送GET请求，就需要使用`Request`对象，通过往`Request`对象添加HTTP头，我们就可以把请求伪装成浏览器。

- 例子：模拟iPhone 6去请求豆瓣首页：

```
from urllib import request

req = request.Request('http://www.douban.com/')
req.add_header('User-Agent', 'Mozilla/6.0 (iPhone; CPU iPhone OS 8_0 like Mac OS X) AppleWebKit/536.26 (KHTML, like Gecko) Version/8.0 Mobile/10A5376e Safari/8536.25')
with request.urlopen(req) as f:
    print('Status:', f.status, f.reason)
    for k, v in f.getheaders():
        print('%s: %s' % (k, v))
    print('Data:', f.read().decode('utf-8'))
```

#### urlopen()

- 语法：`urllib.request.urlopen(url, data=None, [timeout, ]*, cafile=None, capath=None, cadefault=False, context=None)`
  - url:需要打开的网址
  - data: Post 提交的数据, 默认为 None ，发送一个GET请求到指定的页面,当 data 不为 None 时, urlopen() 提交方式为 Post timeout：设置网站访问超时时间
- 方法：
  - read() , readline() , readlines() , fileno() , close() ：这些方法的使用方式与文件对象完全一样
  - info()：返回一个httplib.HTTPMessage对象，表示远程服务器返回的头信息；可以通过Quick Reference to Http Headers查看 Http Header 列
  - getcode()：返回Http状态码。如果是http请求，200表示请求成功完成;404表示网址未找到
  - geturl()：返回获取页面的真实 URL。在 urlopen（或 opener 对象）可能带一个重定向时，此方法很有帮助。获取的页面 URL 不一定跟真实请求的 URL 相同

- 例子：

```
from urllib import request

with request.urlopen('https://www.baidu.com/') as f:
data = f.read()
print('Status:', f.status, f.reason)
# Data的数据格式为bytes类型，需要decode（）解码，转换成str类型
print('Data:', data.decode('utf-8'))
# 头文件获取Content-Length的值
print(f.headers['Content-Length'])
```

#### build_opener()

与urlopen()基本一致，但urlopen()函数不支持验证、cookie或者其它HTTP高级功能。要支持这些功能，必须使用build_opener()函数创建自定义Opener对象。

- 例子：测试网址是否畅通

```
from urllib import request

testurl = "网址"
opener = request.build_opener()
opener.addheaders = [('User-agent', 'Mozilla/49.0.2')]

try:
	opener.open(testurl)
	print(testurl + '没问题')
except urllib.error.HTTPError:
	print(testurl + '=访问页面出错')
except urllib.error.URLError:
	print(testurl + '=访问页面出错')
```

- 例子：代理设置

```
import urllib import request

# 构建一个Handler处理器对象，参数是一个字典类型，包括代理类型和代理服务器IP+Port
httpproxy_handler = request.ProxyHandler({'http':'118.114.77.47:8080'})
#使用代理
opener = request.build_opener(httpproxy_handler)
request = request.Request('http://www.baidu.com/s')

#1 如果这么写，只有使用opener.open()方法发送请求才使用自定义的代理，而urlopen()则不使用自定义代理。
response = opener.open(request)

print response.read()
```



### urllib.error 异常处理模块



### urllib.parse url 负责解析编码

按照标准， URL 只允许一部分ASCII字符（数字字母和部分符号），其他的字符（如汉字）是不符合 URL 标准的。当网址中含有中文是，需要把网址转换为%xx的形式
所以 URL 中使用其他字符就需要进行 URL 编码

#### 转换字符串

- 功能：将单个字符串编码转化为%xx的形式
- 导入：from urllib.parse import quote
- 例子：

```
from urllib.parse import quote

# 特殊符号：汉子、&、=等特殊符号编码为%xx
KEYWORD = '苹果'
url = 'https://taobao.com/search?q=' +quote(KEYWORD)
print(url)
# 结果为：https://taobao.com/search?q=%E8%8B%B9%E6%9E%9C
KEYWORD = '='
url = 'https://taobao.com/search?q=' + quote(KEYWORD)
print(url)
# 运行结果：https://taobao.com/search?q=%3D


# url标准符号：数字字母
KEYWORD = 'ipad'
url = 'https://taobao.com/search?q=' + quote(KEYWORD)
print(url)
# 运行结果：https://taobao.com/search?q=ipad
KEYWORD = '3346778'
url = 'https://taobao.com/search?q=' + quote(KEYWORD)
print(url)
# 运行结果：https://taobao.com/search?q=3346778
```

#### 转换字典

- 功能：将存入的字典参数编码为URL查询字符串，即转换成以key1=value1&key2=value2的形式
- 导入：from urllib.parse import urlencode
- 例子：

```
from urllib.parse import urlencode
base_url = 'https://m.weibo.cn/api/container/getIndex?'

# url标准符号：数字字母
params1 = {
            "value":"english",
            'page':1
        }
url1 = base_url + urlencode(params1)
print(urlencode(params1))
print(url1)
# 运行结果
#value=english&page=1
#https://m.weibo.cn/api/container/getIndex?value=english&page=1

# 特殊符号：汉字,/,&,=,URL编码转化为%xx的形式
params2 = {
            'name':"王二",
            'extra':"/",
            'special':'&',
            'equal':'='
        }
url2 = base_url + urlencode(params2)
print(urlencode(params2))
print(url2)
# 运行结果
#name=%E7%8E%8B%E4%BA%8C&extra=%2F&special=%26&equal=%3D
#https://m.weibo.cn/api/container/getIndex?name=%E7%8E%8B%E4%BA%8C&extra=%2F&special=%26&equal=%3D

print(type(urlencode(params2)))
print(type(url2))
# 运行结果
#<class 'str'>
#<class 'str'>
```



### urllib.robotparser 负责解析robots.txt



## Beautiful Soup

Beautiful Soup提供一些简单的、python式的函数用来处理导航、搜索、修改分析树等功能。自动将输入文档转换为Unicode编码，输出文档转换为utf-8编码。你不需要考虑编码方式，除非文档没有指定一个编码方式，这时，Beautiful Soup就不能自动识别编码方式了

- 例子：遍历文档树

```
from bs4 import BeautifulSoup
soup = BeautifulSoup(html_doc, 'lxml')

'''
遍历文档树：
    1、直接使用
    2、获取标签的名称
    3、获取标签的属性
    4、获取标签的内容
    5、嵌套选择
    6、子节点、子孙节点
    7、父节点、祖先节点
    8、兄弟节点
'''

# 1、直接使用
print(soup.p)  # 查找第一个p标签
print(soup.a)  # 查找第一个a标签

# 2、获取标签的名称
print(soup.head.name)  # 获取head标签的名称

# 3、获取标签的属性
print(soup.a.attrs)  # 获取a标签中的所有属性
print(soup.a.attrs['href'])  # 获取a标签中的href属性

# 4、获取标签的内容
print(soup.p.text)  # $37

# 5、嵌套选择
print(soup.html.head)

# 6、子节点、子孙节点
print(soup.body.children)  # body所有子节点，返回的是迭代器对象
print(list(soup.body.children))  # 强转成列表类型

print(soup.body.descendants)  # 子孙节点
print(list(soup.body.descendants))  # 子孙节点

#  7、父节点、祖先节点
print(soup.p.parent)  # 获取p标签的父亲节点
# 返回的是生成器对象
print(soup.p.parents)  # 获取p标签所有的祖先节点
print(list(soup.p.parents))

# 8、兄弟节点
# 找下一个兄弟
print(soup.p.next_sibling)
# 找下面所有的兄弟，返回的是生成器
print(soup.p.next_siblings)
print(list(soup.p.next_siblings))

# 找上一个兄弟
print(soup.a.previous_sibling)  # 找到第一个a标签的上一个兄弟节点
# 找到a标签上面的所有兄弟节点
print(soup.a.previous_siblings)  # 返回的是生成器
print(list(soup.a.previous_siblings))
```

- 例子：搜索

```
from bs4 import BeautifulSoup
soup = BeautifulSoup(data, "html.parser")

# 使用find_all寻找class名为pure-u的li标签
bf_li = soup.find_all('li', class_='pure-u')

url_bf = BeautifulSoup(str(bf_li), "html.parser")
# 使用find_all寻找class名为pure-u的li标签下 的a标签
url_a = url_bf.find_all('a')
```



------

# Selenium

### 元素定位

#### 定位方法
```
1. id定位：find_element_by_id(self, id_)
2. name定位：find_element_by_name(self, name)
3. class定位：find_element_by_class_name(self, name)
4. tag定位：find_element_by_tag_name(self, name)
5. link定位：find_element_by_link_text(self, link_text)
6. partial_link定位：find_element_by_partial_link_text(self, link_text)
7. xpath定位：find_element_by_xpath(self, xpath)
8. css定位：find_element_by_css_selector(self, css_selector)
```
复数形式
```
9. id复数定位：find_elements_by_id(self, id_)
10. name复数定位：find_elements_by_name(self, name)
11. class复数定位：find_elements_by_class_name(self, name)
12. tag复数定位：find_elements_by_tag_name(self, name)
13. link复数定位：find_elements_by_link_text(self, text)
14. partial_link复数定位：find_elements_by_partial_link_text(self, link_text)
15. xpath复数定位：find_elements_by_xpath(self, xpath)
16. css复数定位：find_elements_by_css_selector(self, css_selector)
```
以下两种即将失传
```
find_element(self, by='id', value=None)
find_elements(self, by='id', value=None)
```
- 例子：使用css定位

```
from selenium import webdriver

browser = webdriver.Chrome()
browser.get('网址')
# 定位到网页中ID为img0下包含的img标签，并获取img标签中的src值
pic_html = browser.find_element_by_css_selector('#img0>img').get_attribute('src'))
browser.close()
```



#### 区别

1.element方法定位到是是单数，是直接定位到元素

2.elements方法是复数，这个学过英文的都知道，定位到的是一组元素，返回的是list队列

3.可以用type()函数查看数据类型

4.打印这个返回的内容看看有什么不一样



### 判断元素存在

1. find_elements方法判断

```
def is_element_exist(css)
	s = driver.find_elements_by_css_selector(css_sclector=css)
	is len(s) == 0:
		print("元素未找到：%s" % css)
		return False
	elif len(s) == 1:
		return True
	else:
		print("找到%s个元素： %s" % (len(s),css)
		return False
```

2. 捕获异常方法

```
def is_element_exist(css)
	try:
		driver.find_element_by_css_selector(css)
		return True
	except:
		return False
```



------

# 转码

ASCII 是一种字符集,包括大小写的英文字母、数字、控制字符等，它用一个字节表示，范围是 0-127 Unicode分为UTF-8和UTF-16。

Python 从 2.2 开始支持 Unicode ，函数 decode( char_set )可以实现 其它编码到 Unicode 的转换，函数 encode( char_set )实现 Unicode 到其它编码方式的转换。

```
("你好").decode( "GB2312")
# 结果： u'\u4f60\u597d'

(u'\u4f60\u597d').encode("UTF-8")
# 结果：'\xe4\xbd\xa0\xe5\xa5\xbd'
# 这是utf8的编码结果
```

unicode的关键：unicode是一个类，函数unicode(str,"utf8")从utf8编码（当然也可以是别的编码）的字符串str生成 unicode类的对象，而函数unc.encode("utf8")将unicode类的对象unc转换为（编码为）utf8编码（当然也可以是别的编码）的字符串

```
unicode("你好", "utf8")  
# 结果：u'\u4f60\u597d'  
   
x = _  
type(x)  
type("你好")  
   
x.encode("utf8")  
# 结果：'\xe4\xbd\xa0\xe5\xa5\xbd'  
x.encode("gbk")  
# 结果：'\xc4\xe3\xba\xc3'  
x.encode("gb2312")  
# 结果：'\xc4\xe3\xba\xc3'  
   
print x  
# 结果：你好  
print x.encode("utf8")  
# 结果：你好  
print x.encode("gbk")  
# 结果：???  
```

Python3的字符串的编码语言用的是unicode编码，由于Python的字符串类型是str，在内存中以Unicode表示，一个字符对应若干字节，如果要在网络上传输，或保存在磁盘上就需要把str变成以字节为单位的bytes

```
c = str(b'\xe4\xbd\xa0\xe5\xa5\xbd', "UTF-8")
# 结果： 你好
```


<div id="toTop">
  <a href="#" class="ryi-angle-up"></a>
</div>