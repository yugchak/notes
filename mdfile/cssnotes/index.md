<head>
  <script type="text/javascript">
  (function() {
    var link = document.createElement('link');
    link.type = 'image/x-icon';
    link.rel = 'shortcut icon';
    link.href = '../h.ico';
    document.getElementsByTagName('head')[0].appendChild(link);
  }());
  </script>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>


- [CSS长度单位](#CSS长度单位)

  - [绝对长度单位](#绝对长度单位)
  - [相对长度单位](#相对长度单位)

  - [em](#em)
  - [rem](#rem)
  - [rpx](#rpx)
  - [vw 和 vh](#vw 和 vh)
  - [vmin 和 vmax](vmin 和 vmax)




## CSS长度单位

#### 绝对长度单位

绝对长度单位表示为一个固定的值，不会改变。不利于页面渲染。

- in,英寸
- cm, 里面
- mm, 毫米
- pt
- pc

#### 相对长度单位

其长度单位会随着它的参考值的变化而变化。

- px,像素
- em,元素的字体高度
- %,百分比
- rem,根元素的font-size
- vm,视窗宽度，1vw=视窗宽度的1%
- vh,视窗高度，1vh=视窗高度的1%
  



### em

em是相对长度单位。相对于当前对象内文本的字体尺寸。如当前对行内文本的字体尺寸未被人为设置，**则相对于浏览器的默认字体尺寸,浏览器字体默认为16px**。

- 所以，1em = 16px。默认情况下。

  > 高效使用em

- body里声明font-size:62.5%。即全局声明`1em = 16px * 62.5% = 10px`
- 之后可以把`em`当做`px`使用。当然此时，`1em = 10px`
- 如果在父容器里说明了`font-size:20px`,那么在子容器里的`1em`就等于`20px`。

### rem

rem单位是相对于字体大小的**html元素**，也称为根元素。



- rem是相对于根元素（html）的字体大小，而em是相对于其父元素的字体大小。

- em最多取到小数点的后三位

  ```
  <style>
    html{ font-size: 20px; }
    body{ 
      font-size: 1.4rem;  /* 1rem = 28px */
      padding: 0.7rem;  /* 0.7rem = 14px */
    } 
    div{
      padding: 1em;  /* 1em = 28px */
    }
    span{
      font-size:1rem;  /* 1rem = 20px */
      padding: 0.9em;  /* 1em = 18px */
    }
  </style>
  
  
  <html>
    <body>
      <div>   
        <span></span>  
      </div>
    </body>
  </html>
  ```

  em 会层层继承父元素的字体大小，很容易造成字体大小的混乱



### rpx

**rpx 是微信小程序解决自适应屏幕尺寸的尺寸单位。微信小程序规定屏幕的宽度为750rpx。**

无论是在iPhone6上面还是其他机型上面都是750rpx的屏幕宽度，拿iPhone6来讲，屏幕宽度为375px，把它分为750rpx后， 1rpx = 0.5px = 1物理像素。



### vw 和 vh

- `vw`,视窗宽度，1vw=视窗宽度的1%
- `vh`,视窗高度，1vh=视窗高度的1%
- 如果浏览器的高是900px,1vh求得的值为9px。同理，如果显示窗口宽度为750px,1vw求得的值为7.5px。



### vmin 和 vmax

- vmin和vmax是相对于视口的高度和宽度两者之间的最小值或最大值。
- 浏览器的高为1100px、宽为700px，那么1vmin就是7px，1vmax就是11px
- 浏览器的高为800px，宽为1080px，那么1vmin也是8px，1vmax也是10.8px
- vmin取宽度高度两者更小者/100
- vmax取宽度高度两者更大者/100
  


<div id="toTop">
  <a href="#" class="ryi-angle-up"></a>
</div>


