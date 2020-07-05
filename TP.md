## TP框架制作网站

### 一、网站域名:weili.cn

### 二、模块

- 前台模块  **index**
- 后台模块  **admin**

### 三、数据库表名设计

#### 类别管理表       **sort**

| ID         | id          |
| :--------- | :---------- |
| 父级ID     | parent_id   |
| 名称       | sortname    |
| 层级       | level       |
| 链接地址   | linkname    |
| 软删除时间 | delete_time |

#### banner图

| ID       | id        |
| -------- | --------- |
| 父级ID   | parent_id |
| 名称     | title     |
| 发布     | publish   |
| 添加时间 | add_time  |

#### 关于我们     **aboutus**

| ID       | id       |
| :------- | :------- |
| 所属类别 | sortname |
| 内容     | content  |
| 是否发布 | publish  |
| 图片     | img      |
| 浏览次数 | views    |
| 发布时间 | add_time |

#### 新闻资讯表   **news**

| ID         | id          |
| ---------- | ----------- |
| 标题       | title       |
| 所属类别   | sortname    |
| 内容       | content     |
| 浏览次数   | views       |
| 是否发布   | publish     |
| 发布时间   | add_time    |
| 软删除时间 | delete_time |

#### 企业服务（ Enterprise Services）   **ent_services** 

| ID         | id          |
| ---------- | ----------- |
| 标题       | title       |
| 所属类别   | sortname    |
| 内容       | content     |
| 浏览次数   | views       |
| 是否发布   | publish     |
| 发布时间   | add_time    |
| 软删除时间 | delete_time |

#### 员工服务(Employee services)    **emp_services**

| ID         | id          |
| ---------- | ----------- |
| 标题       | title       |
| 所属类别   | sortname    |
| 内容       | content     |
| 浏览次数   | views       |
| 是否发布   | publish     |
| 发布时间   | add_time    |
| 软删除时间 | delete_time |

#### 求职招聘   job

###### 注意：

- 在模块当中 ，**职场快讯、面试宝典、招生简章**属于一个类似的模块，用同一张数据表。**job_news**
- 在线求职  需要设计一张专门的表来接收前台用户传来的信息表.**job_message**
- 招聘信息。**job_info** ****

###### 表一  job_news

| ID         | id          |
| ---------- | ----------- |
| 标题       | title       |
| 所属类别   | sortname    |
| 内容       | content     |
| 浏览次数   | views       |
| 是否发布   | publish     |
| 发布时间   | add_time    |
| 软删除时间 | delete_time |

###### 表二 job_message

| ID       | id          |
| -------- | ----------- |
| 姓名     | name        |
| 性别     | sex         |
| 手机号码 | tel         |
| 意向工作 | work        |
| 添加时间 | add_time    |
| 审阅     | verify      |
| 审核时间 | verify_time |

###### 表三 job_info

| ID       | id         |
| -------- | ---------- |
| 招聘岗位 | station    |
| 招聘部门 | department |
| 学历要求 | degree     |
| 预计薪资 | salary     |
| 需求人数 | people     |
| 岗位职责 | response   |
| 岗位要求 | demand     |
| 福利待遇 | benefit    |
| 发布时间 | add_time   |
| 是否发布 | publish    |

#### 联系我们

###### 注意：

- 联系我们分为两个模块
  1. 一个是联系我们的相信信息 **contactus**
  2. 二是用户的在线留言信息**online_message**

###### 表一  contactus

| ID             |    id    |
| :------------- | :------: |
| 添加的信息标题 |  title   |
| 添加的信息内容 | content  |
| 添加时间       | add_time |

###### 表二 online_message

| ID       | id       |
| -------- | -------- |
| 姓名     | name     |
| 手机号码 | tel      |
| 留言信息 | message  |
| 添加时间 | add_time |
| 审阅     | verify   |

#### 下载设置 dowload

上传文件供用户下载,文件格式包含且（照片，文档，压缩包）

| ID       | id       |
| -------- | -------- |
| 文件标题 | title    |
| 发布时间 | add_time |
| 下载次数 | times    |
| 是否发布 | publish  |

#### 友情链接 links

| ID       | id       |
| -------- | -------- |
| 链接标题 | title    |
| 链接     | link     |
| 添加时间 | add_time |
| 是否发布 | publish  |

### 四、操作要求

1. 每个页面应该具有的功能，都运用**AJAX**来实现功能,请求都是传递**id值**

   - 添加
   - 删除
   - 修改
   - 查找

2. 所有后台发布的信息，应该设有一个判断的值，判断是否将内容发布到前台

   - 0-不发布，存为草稿
   - 1-发布到前台

3. ajax  请求返回数据

   - 失败 data=[

     'code'=>0,

     'msg'=>'请求失败'

     ]

   - 成功 data=[

     'code'=>1,

     'msg'=>'请求成功',

     'data':**数组对象**

     ]









