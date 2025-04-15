# HeyBurrito 项目结构文档

## 项目概述
HeyBurrito 是一个开源的 Slack Bot 项目，用于替代 HeyTaco 功能。

## 技术栈
- PHP 8.1+
- Laravel 框架
- MySQL 数据库
- Slack API

## 目录结构
```
HeyBurrito/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── BurritoController.php    # 处理 Slack 事件
│   │   │   ├── EventController.php      # 处理事件存储
│   │   │   ├── UserController.php       # 用户管理
│   │   │   └── MockSlackAPI.php         # Slack API 模拟
│   │   ├── Middleware/
│   │   │   ├── SlackEvent.php           # Slack 事件验证
│   │   │   └── TokenAuth.php            # 令牌验证
│   │   └── Requests/
│   │       └── EventPostRequest.php     # 事件请求验证
│   ├── Models/
│   │   ├── Event.php                    # 事件模型
│   │   ├── User.php                     # 用户模型
│   │   └── Burrito.php                  # Burrito 模型
│   └── Slack/
│       └── SlackUserData.php            # Slack 用户数据处理
├── config/
├── database/
│   └── migrations/                      # 数据库迁移文件
├── routes/
│   └── api.php                          # API 路由定义
└── tests/                               # 测试文件
```

## API 规范

### 1. Event API
```
POST /api/event
用途：处理 Slack 事件
请求体：
{
    "token": "验证令牌",
    "team_id": "团队ID",
    "event": {
        "type": "app_mention",
        "user": "用户ID",
        "text": "消息内容",
        "channel": "频道ID"
    },
    "type": "event_callback"
}
响应：
- 成功：200 OK
- 失败：相应的错误状态码
```

### 2. User API
```
GET /api/user
用途：获取用户列表
需要认证：是

POST /api/user
用途：创建新用户
需要认证：是
请求体：
{
    "username": "用户名"
}

PATCH /api/user/{username}
用途：更新用户信息
需要认证：是

DELETE /api/user/{userId}
用途：删除用户
需要认证：是
```

### 3. Slack Mock API
```
GET /api/slack
用途：测试端点

GET /api/slack/event/{eventType}
用途：模拟 Slack 事件
参数：
- eventType: challenge/app_mention/message/slash_command

GET /api/slack/users.list
用途：模拟 Slack 用户列表 API
```

## 数据库结构

### events 表
- id: 主键
- type: 事件类型
- user: 用户ID
- channel: 频道ID
- text: 消息内容
- created_at: 创建时间
- updated_at: 更新时间

### users 表
- id: 主键
- user_id: Slack 用户ID
- name: 用户名
- created_at: 创建时间
- updated_at: 更新时间

### burrito 表
- id: 主键
- burrito_giver: 赠送者
- burrito_receiver: 接收者
- message_sent_to_giver: 是否发送消息给赠送者
- message_sent_to_receiver: 是否发送消息给接收者
- created_at: 创建时间
- updated_at: 更新时间

## 环境要求
- PHP 8.1+
- MySQL 5.7+
- Composer
- SSL 证书（用于 Slack API）
- Slack App 配置

## 配置说明
1. 复制 .env.example 为 .env
2. 配置数据库连接
3. 设置 Slack API 凭证
4. 配置日志级别

## 部署说明
1. 安装依赖：`composer install`
2. 生成密钥：`php artisan key:generate`
3. 运行迁移：`php artisan migrate`
4. 启动服务：`php artisan serve`
5. 配置 Slack App 事件订阅 