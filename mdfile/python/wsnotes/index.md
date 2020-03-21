

## Selenium

### 元素定位

#### 定位方法

1. id定位：find_element_by_id(self, id_)
2. name定位：find_element_by_name(self, name)
3. class定位：find_element_by_class_name(self, name)
4. tag定位：find_element_by_tag_name(self, name)
5. link定位：find_element_by_link_text(self, link_text)
6. partial_link定位find_element_by_partial_link_text(self, link_text)
7. xpath定位：find_element_by_xpath(self, xpath)
8. css定位：find_element_by_css_selector(self, css_selector）

复数形式

9. id复数定位find_elements_by_id(self, id_)
10. name复数定位find_elements_by_name(self, name)
11. class复数定位find_elements_by_class_name(self, name)
12. tag复数定位find_elements_by_tag_name(self, name)
13. link复数定位find_elements_by_link_text(self, text)
14. partial_link复数定位find_elements_by_partial_link_text(self, link_text)
15. xpath复数定位find_elements_by_xpath(self, xpath)
16. css复数定位find_elements_by_css_selector(self, css_selector)

以下两种即将失传
find_element(self, by='id', value=None)
find_elements(self, by='id', value=None)

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

## 转码

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



------

## 网址编码

当网址中含有中文是，需要把网址转换为%xx的形式

### 1.转换字符串

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

### 2.转换字典

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

