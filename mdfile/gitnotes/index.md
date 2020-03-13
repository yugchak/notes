- [本地初始化仓库](#本地初始化仓库)
- [获取远程仓库](#获取远程仓库)
- [添加文件或者文件夹](#添加文件或者文件夹)
- [删除文件或者文件夹](#删除文件或者文件夹)
- [检查状态](#检查状态)
- [提交修改](#提交修改)
- [暂存区](#暂存区)
- [分支](#分支)
- [VIM](#VIM)
	 - [正常模式命令](#正常模式命令)
	 - [切换插入模式](#切换插入模式)
	 - [切换可视模式](#切换可视模式)
- [文件的移动](#文件的移动)








## 本地初始化仓库

```md
$ mkdir demo									# 在本地创建文件夹用作仓库
$ cd demo										# 进入文件夹
$ git init										# 文件夹初始化为本地仓库
```



## 获取远程仓库

```md
$ git clone	<版本库网址> <本地目录名>		 	  # 本地目录名为可选项，支持HTTP(s)、SSH、Git、本地文件协议

$ git pull [<options>] [<repository> [<refspec>…​]]
	<repository>							# 仓库名字
	<refspec>								# 分支名字
	origin master							# 拉取远程服务器origin的master分支

$ git remote -v								# 查看当前仓库的远端地址，从下方看到是 https格式的
$ git remote add origin <url>			# 使用add添加新的仓库地址
$ git remote rm <仓库名>					  # 删除名字为<仓库名>的远端地址
$ git remote rename <仓库名> <修改名>			# 把<仓库名>修改为<修改名>
```



## 添加文件或者文件夹

```md
$ dir                                           # 查看有哪些文件夹

$ mkdir test									# 直接创建test文件夹
$ echo "testing" > 1.txt		              	# 添加文本到1.txt
$ git add 2.txt					              	# 本地添加文件后使用add命令添加文件
$ touch 3.txt					              	# 直接使用touch命令新建文件

$ git add .										# 需要把修改添加到暂存区
$ git commit -m '删除了target'        				# 提交,添加操作说明
$ git push -u origin master						# 把本地仓库的修改推送到远程仓库

$ git status									# 查看状态是否还有未提交内容
```

仓库分为工作区、暂存区、提交区，文件夹即是工作区，现在我们新建一个空文件并使用git add <文件名>把它添加到暂存区，随后使用`git commit -m "注释"` 把它提交到版本库

```
$ git add .
# 他会监控工作区的状态树，使用它会把工作时的所有变化提交到暂存区，包括文件内容修改(modified)以及新文件(new)，但不包括被删除的文件

$ git add -u
# 他仅监控已经被add的文件(即tracked file)，他会将被修改的文件提交到暂存区。add -u 不会提交新文件(untracked file)。(git add --update的缩写)

$ git add -A
# 是上面两个功能的合集(git add --all的缩写)
```



## 删除文件或者文件夹

```md
$ git pull origin master						# 将远程仓库里面的项目拉下来
$ git clone git@github.com:名字/库名.git		  # 或者克隆远程仓库里面的项目

$ dir                                           # 查看有哪些文件夹

$ git rm -r --cached target              		# 删除target文件夹
$ git rm 1.txt									# 删除1.txt文件
$ git clean -n									# 查看将会删除哪些文件（不会真正删除)
$ Git clean -f <path>							# 删除当前目录下没有缓存的文件
$ git clean -df <path>							# 删除当前目录下没有缓存的文件和文件夹
$ git restet --hard								# 重置到上次commit的记录，后面修改的文件和新增的文件不会被track,配合git clean -df回到上次提交的commit时的内容。

$ git commit -m '删除了target'        			  # 提交,添加操作说明
$ git push -u origin master						# 把本地仓库的修改推送到远程仓库
```



## 检查状态

```md
$ git status						# 查看当前仓库中文件的状态
	-s	--short						# 以短格式输出(M-修改,A-添加,D-删除,R-重命名,??-未追踪)
	-b	--branch					# 以短格式显示分支和跟踪信息
	--long							# 以长格式输出输出。这是默认设置
	-uno							# 可以只列出所有已经被git管理的且被修改但没提交的文件
```

`git status`不显示已经`commit`到项目历史中去的信息。看项目历史的信息要使用`git log`.



## 提交修改

```md
$ git commit –m "本次提交描述"
```

该命令会将`git add .`存入暂存区修改内容提交至本地仓库中，若文件未添加至暂存区，则提交时不会提交任何修改

```md
$ git commit –am "本次提交描述"
$ git commit –a –m "本次提交描述"
```

该命令会将本地工作区中修改后，还未使用git add . 命令添加到暂存区中的文件也一并提交上去。相当于`git add -u` 与`git commit –m "本次提交描述"` 两句操作合并为一句进行使用

```md
$ git commit –-amend
```

`git commit --amend` //也叫追加提交，它可以在不增加一个新的`commit-id`的情况下将新修改的代码追加到前一次的`commit-id`中

```md
$ git commit -m '
> 1.aaaaa
> 2.bbbb
> '
[master b25154b] 1.aaaaa 2.bbbb
 1 file changed, 0 insertions(+), 0 deletions(-)
 create mode 100644 ss.tx
```

`git commit -m` 注释可以通过单引号来换行



## 暂存区

```md
# 仅仅删除暂存区的文件而已，不会影响工作区的文件
$ git rm --cache <文件名>						  # 仅仅删除暂存区里的文件

# 暂存区和本地文件会一同删除
$ git rm -f <文件名>							  # 删除暂存区和工作区的文件
$ git rm -f -r <文件夹名>                         # 删除暂存区和工作区的文件夹包括文件夹里的内容

# 删除错误提交的commit，需使用git reset
$ git reset --soft 版本库ID                      # 只撤销已提交的版本库，不会修改暂存区和工作区
$ git reset --mixed 版本库ID					  # 只撤销已提交的版本库和暂存区，不会修改工作区
$ git reset --hard 版本库ID		              # 将工作区、暂存区和版本库记录恢复到指定的版本库

# 取消暂存(track)
$ git restore --staged <FileName>

# 加入暂存(track)					
$ git add .										# 点是全部修改新增文件暂存
$ git add <FileName>							# 暂存对应文件
```



## 分支

```md
$ git branch <分支名>					  # 创建分支
$ git push origin --delete <BranchName>	# 删除远程分支
$ git branch							# 没有参数时，会列出你在本地的分支
	--list								# 如果没有非选项参数，则列出现有分支
	-r									# 导致远程追踪分支被列出
	-a	--all							# 显示本地和远程分支
	-d	--delete						# 删除分支，该分支必须完全合并到其上游分支中
	-D	--delete --force				# 快捷键
	
$ git checkout -b myRel origin/Release  # 本地起名为myRel分支，并切换到本地的myRelase分支
$ git checkout <分支名>				  # 切换分支
	-b									# 创建新分支并立即切换到该分支下
	
$ git merge								# 合并分支

$ git reset --hard <commit-id>			# 撤消上一次commit的内容(该操作会彻底回退到某个版本，本地的源码也会变为上一个版本的内容)
$ git remote update -p --prune			# 更新远程分支列表
```

```md
$ git log								# 按提交时间列出所有的更新
	-p -2								# 显示每次提交的内容差异
	-<n>								# 显示最近的n次更新
	--since=2.weeks						# 列出所有最近两周内的提交
	--stat								# 显示简要的增改行数统计
	--pretty							# 可以指定使用完全不同于默认格式的方式展示提交历史
	--pretty=format:					# 定制格式 format，可以定制要显示的记录格式
```

| 选项 | 说明                                       |
| ---- | ------------------------------------------ |
| %H   | 提交对象（commit）的完整哈希字串           |
| %h   | 提交对象的简短哈希字串                     |
| %T   | 树对象（tree）的完整哈希字串               |
| %t   | 树对象的简短哈希字串                       |
| %P   | 父对象（parent）的完整哈希字串             |
| %p   | 父对象的简短哈希字串                       |
| %an  | 作者（author）的名字                       |
| %ae  | 作者的电子邮件地址                         |
| %ad  | 作者修订日期（可以用 -date= 选项定制格式） |
| %ar  | 作者修订日期，按多久以前的方式显示         |
| %cn  | 提交者(committer)的名字                    |
| %ce  | 提交者的电子邮件地址                       |
| %cd  | 提交日期                                   |
| %cr  | 提交日期，按多久以前的方式显示             |
| %s   | 提交说明                                   |



## VIM

```md
$ vim test.txt			# 打开要编辑的文本
$ vim +#				# 打开文件，并定位到#行
```

vim 四种模式：
     正常模式；命名模式；插入模式；可视模式。从其他模式退出到正常模式的时候esc即可

##### 正常模式命令

```md
h	# 向前一个字符
l	# 向后一个字符
j	# 同位置向下走
k	# 同位置向上走
n	# 查找下一个
N	# 查找上一个
这几个命令前加上数字，表示向前多少个字符
```

```md
:q		# 退出编辑
:wq		# 保存并退出
:q!		# 不保存退出
:w		# 保存
:w!		# 强行保存
:e!		# 退回到文件打开后最后一次保存操作的状态

w		# 移到下一个单词的词首
e		# 跳到当前或下一个单词的词尾
b		# 跳到当前或前一个单词的词首
#w		# 移动#个单词

gg		# 第一行
G		# 最后一行
#G		# 跳到第几行

Ctrl+f	# 向下翻一屛
ctrl+b	# 向上翻一屛
ctrl+d	# 向下翻半屛
ctrl+u	# 向上翻半屛

x		# 删除当前光标所在位置的一个字符
#x		# 删除光标所在位置及向后的#个字符
dd		# 删除当前光标所在行

yy		# 复制一行
p		# 粘贴,粘贴一行的话，放在当前行的下边。
u		# 撤销操作
```
##### 切换插入模式

```
i			# 在光标所在字符前输入，转到输入模式
a			# 在光标所在字符后输入，转到输入模式
o(字母o)	   # 在光标所在行的下面单独开一行，并转到输入模式
s			# 删除光标所在的字符，并进入到输入模式
I(大写i)	   # 在当前行的行首开始输入文字，并进入输入模式。如果在行首有空格，则在空格后开始插入。
A		     # 在行尾进行输入。进入输入模式
O(大写O)		# 在当前行的前一行插入空行，并进入输入模式
S			# 删除光标所在的一行，并进入输入模式。
```

##### 切换可视模式

可视模式（就是可以选取一行，或者选取一个区域）：

```
v			# 进入可视模式，然后使用方向控制就可以进行选取
```



## 文件的移动

```md
$ git mv 1.txt lib                	# 将1.txt移动lib文件夹
$ git mv 1.txt ./lib/2.txt		    # 修改文件名并移动到lib
$ git mv ./lib/2.txt 1.txt 		    # 从lib文件夹移动出来并修改文件名
$ git mv 1.txt 2.rb					# 修改文件名和修改文件后缀
```



