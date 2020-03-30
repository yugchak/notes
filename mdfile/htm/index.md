<head>
	<script type="text/javascript">
	(function() {
		var link = document.createElement('link');
		link.type = 'image/x-icon';
		link.rel = 'shortcut icon';
		link.href = '../../h.ico';
		document.getElementsByTagName('head')[0].appendChild(link);
	}());
	</script>
	<link rel="stylesheet" type="text/css" href="../style.css">
</head>


- [锚点](#锚点)
	- [同一页面跳转](#同一页面跳转)
	- [不同页面跳转](#不同页面跳转)
	- [触发js事件跳转](#触发js事件跳转)
- [响应式网页](#响应式网页)
	- [CSS的@media规则](#CSS的@media规则)
	- [选择加载CSS](#选择加载CSS)
- [编码](#编码)
  - [GBK](#gbk)
  - [GB18030](#gn18030)
  - [GB2312](#gb2312)
  - [UTF(UCS Transfer Format)](#utfucs-transfer-format)
  - [Unicode](#unicode)



## 锚点



#### **同一页面跳转**

```
<a name="add"></a> 或者 <p id="add"></p> （ps：用id兼容性好些）
<a href="#add">跳转到add</a>
<a href="#">返回页面顶部</a>
```

#### **不同页面跳转**

```
在不同页面中，锚点定位在a.html中，从另外一个页面的链接跳转到这个锚点
<a href="a.html#add">跳转到a.add</a>
```

#### **触发js事件跳转**

第一种：

```
<a href="#add" onclick="add()">触发add函数并跳转到add锚点</a>
```

第二种：

```
<p id="pNode"></p> 
<a href="#" onclick="document.getElemetnById('pNode').scrollIntoView(true);return false;">通过scrollIntoView实现锚点效果</a>
```

> scrollIntoView()的用法
>  **scrollIntoView**是一个与页面（容器）滚动相关的API（[官方解释](https://drafts.csswg.org/cssom-view/#dom-element-scrollintoview)），该API只有boolean类型的参数能得到良好的支持（firefox 36+都支持），所以在这里只讨论参数Boolean类型的情况
>  调用方法为 element.scrollIntoView() 参数默认为true。
>
> 参数为true时调用该函数，页面（或容器）发生滚动，使element的顶部与视图（容器）顶部对齐；
>
> 参数为false时，使element的底部与视图（容器）底部对齐。
>
> TIPS：页面（容器）可滚动时才有用！



## 响应式网页



#### **CSS的@media规则**

```
/*通用样式*/
*{
	margin:0;padding:0;text-decoration:none;list-style:none;
	font-size:14px;font-family:"微软雅黑";text-align:center;
	color:#fff;
}
.clear{
	clear:both;
}
#header,#content,#footer{
	margin:0 auto;margin-top:10px;
}  
#header,#footer{
	margin-top:10px;height:100px;
}
#header,#footer,.left,.right,.center{
	background:#333;
}

/*手机*/
@media screen and (max-width:600px){
	#header,#content,#footer{
		width:400px;}
	.right,.center{
		margin-top:10px;}
	.left,.right{
		height:100px;}
	.center{
		height:200px;}
}

/*平板*/
@media screen and (min-width:600px) and (max-width:960px){
	#header,#content,#footer{
		width:600px;}
	.right{
		display:none;}
	.left,.center{
		height:400px;float:left;}
	.left{
		width:160px;margin-right:10px;}
	.center{
		width:430px;}
}

/*PC*/
@media screen and (min-width:960px){
	#header,#content,#footer{
		width:960px;}
	.left,.center,.right{
		height:400px;float:left;}
	.left{
		width:200px;margin-right:10px;}
	.center{
		width:540px;margin-right:10px;}
	.right{
		width:200px;} 
}
```



------



#### **选择加载CSS**

```
<link rel="stylesheet" type="text/css"
media="screen and (max-device-width: 400px)"
href="tinyScreen.css" />
```

如果屏幕宽度小于400像素（max-device-width: 400px），就加载tinyScreen.css文件

```
<link rel="stylesheet" type="text/css"
media="screen and (min-width: 400px) and (max-device-width: 600px)"
href="smallScreen.css" />
```

如果屏幕宽度在400像素到600像素之间，则加载smallScreen.css文件。


<div id="toTop">
  <a href="#" class="ryi-angle-up"></a>
</div>



## 编码

#### GBK

简单而言，GBK是对GB2312的进一步扩展（K是汉语拼音kuo zhan（扩展）中扩的声母），收录了21886个汉字和符号，完全兼容GB2312

#### GB18030

GB18030收录了70244个汉字和字符，更加全面，与GB 2312-1980和GBK兼容。

GB18030支持少数民族的汉字，也包含了繁体汉字和日韩汉字。

其编码是单、双、四字节边长编码。

#### GB2312

当国人得到计算机后，那就要对汉字进行编码。在ASCII码表的基础上，小于127的字符意义与原来相同；而将两个大于127的字节连在一起，来表示汉字，前一个字节从0xA1(161)到0xF7(247)共87个字节，称为高字节，后一个字节从0xA1(161)到0xFE(254)共94个字节，称为低字节，两者可组合出约8000种组合，用来表示6763个简体汉字、数学符号、罗马字母、日文字等。

在重新编码的数学、标点、字母是两字节长的编码，这些称为“全角”字符；而原来在ASCII码表的127以下的称为“全角”字符。

#### UTF(UCS Transfer Format)

UTF是在互联网上使用最广的一种Unicode的实现方式。我们最常用的是UTF-8，表示每次8个位传输数据，除此之外还有UTF-16。

- 例子：UTF-8显示 “你好中国！hello，123”

```
&#x4F60;&#x597D;&#x4E2D;&#x56FD;&#xFF01;hello&#xFF0C;123
```

#### Unicode

准确来说，Unicode不是编码格式，而是字符集。这个字符集包含了世界上目前所有的符号。

另外，原来有些字符可以用一个字节即8位来表示的，Unicode将所有字符的长度统一为16位，因此字符是定长的。

- 例子：Unicode显示 “你好中国！hello，123”

```
\u4f60\u597d\u4e2d\u56fd\uff01\u0068\u0065\u006c\u006c\u006f\uff0c\u0031\u0032\u0033
```

