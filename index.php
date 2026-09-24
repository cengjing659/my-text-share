<?php
// ========== 管理员设置区 ==========
$adminPassword = "654321"; // 在这里设置你的重置密码（建议修改为复杂密码）
// ================================

// 1. 在这里填入你的预设文本
$texts = [
    9.74 复制打开抖音，看看【NG甜甜的图文作品】如果明天的路你不知道该往哪走  https://v.douyin.com/buyDbFE5BCQ/ Ljp:/ h@B.TY :3pm 12/20,
    2.00 复制打开抖音，看看【伦.的图文作品】如果一定要上岸 那一定是西海岸  https://v.douyin.com/ot_Rls9MbP8/ 08/30 u@s.EH ytE:/ :3pm,
   1.07 复制打开抖音，看看【一顿要吃三碗饭的图文作品】西海岸  https://v.douyin.com/u8jcB5IH21o/ QkC:/ x@f.Ok 06/13 :9pm,
    9.74 复制打开抖音，看看【NG甜甜的图文作品】如果明天的路你不知道该往哪走  https://v.douyin.com/buyDbFE5BCQ/ Ljp:/ h@B.TY :3pm 12/20,
    2.00 复制打开抖音，看看【伦.的图文作品】如果一定要上岸 那一定是西海岸  https://v.douyin.com/ot_Rls9MbP8/ 08/30 u@s.EH ytE:/ :3pm,
    "这是最后一条文本内容"
];

// 2. 记录全局访问进度的文件
$counterFile = "visit_counter.txt";
if (!file_exists($counterFile)) {
    file_put_contents($counterFile, 0);
}

// 3. 处理管理员重置请求（密码验证）
$resetSuccess = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reset']) && $_POST['password'] === $adminPassword) {
    file_put_contents($counterFile, 0);
    $resetSuccess = true;
}

// 4. 核心逻辑：每次访问直接分配新文本（不使用Cookie，刷新即换新）
$current = (int)file_get_contents($counterFile);
if ($current < count($texts)) {
    $index = $current;
    // 全局计数器+1
    file_put_contents($counterFile, $current + 1);
} else {
    $index = -1; // 标记为已发完
}

// 5. 准备展示的内容
if ($index >= 0 && $index < count($texts)) {
    $content = $texts[$index];
} else {
    $content = "️ 文本已全部发放完毕，暂无新内容。";
}
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>文本分享</title>
    <style>
        body { font-family: sans-serif; display: flex; justify-content: center; align-items: center; min-height: 100vh; background: #f5f5f5; padding: 20px; }
        .card { background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); max-width: 500px; width: 100%; text-align: center; line-height: 1.6; }
        .content { margin: 20px 0; padding: 15px; background: #eee; border-radius: 5px; text-align: left; word-wrap: break-word; user-select: text; }
        .copy-btn { display: inline-block; padding: 10px 25px; background: #07c160; color: #fff; border-radius: 20px; font-size: 14px; cursor: pointer; margin-top: 10px; border: none; outline: none; transition: background 0.3s; }
        .copy-btn:active { background: #06ad56; }
        .tip { font-size: 12px; color: #999; margin-top: 15px; }
        
        /* 管理员区域样式 */
        .admin-area { margin-top: 30px; border-top: 1px dashed #ddd; padding-top: 15px; }
        .admin-btn { font-size: 12px; color: #aaa; cursor: pointer; background: none; border: none; }
        .admin-panel { display: none; margin-top: 10px; padding: 15px; background: #fff8e1; border-radius: 5px; }
        .admin-panel input { padding: 8px; border: 1px solid #ddd; border-radius: 4px; width: 100px; }
        .admin-panel button { padding: 8px 15px; background: #e74c3c; color: #fff; border: none; border-radius: 4px; cursor: pointer; }
        .success-msg { color: #27ae60; font-weight: bold; margin-top: 10px; }
    </style>
</head>
<body>
    <div class="card">
        <h3> 你的专属文本</h3>
        <div class="content" id="textContent"><?= htmlspecialchars($content) ?></div>
        
        <!-- 一键复制按钮 -->
        <button class="copy-btn" onclick="copyText()"> 一键复制文本</button>
        
        <!-- 提示语 -->
        <p class="tip">⚠️ 刷新页面可获取下一条，请注意保存</p>

        <!-- 只有你知道的管理员入口 -->
        <div class="admin-area">
            <button class="admin-btn" onclick="toggleAdmin()">🛠️ 管理员入口</button>
            <div class="admin-panel" id="adminPanel">
                <?php 如果 ($resetSuccess): ?>
                    <div class="success-msg">✅ 进度已重置成功！</div>
                <?php 否则: ?>
                    <form method="POST">
                        <input type="password" name="password" placeholder="请输入密码" required>
                        <button type="submit" name="reset">重置进度</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <脚本>
        // 切换管理员面板显示
        函数 toggleAdmin() {
            常量 panel = 文档.getElementById('adminPanel');
            panel.style.display = panel.style.display === 'block' ? 'none' : 'block';
        }

        // 复制功能
        function copyText() {
            const text = document.getElementById('textContent').innerText;
            如果 (导航器.剪贴板 && 窗口.是否为安全上下文) {
                导航器.剪贴板.writeText(文本).然后(() => 警告('复制成功！')).捕获(() => 备用文案(文本));
            } 否则 {
                备用文案(文本);
            }
        }

        // 兼容旧浏览器或HTTP环境
        函数 备用文案(文本) {
            常量 文本区域 = 文档.createElement('textarea');
            文本区域.value = 文本;
            文档.正文.appendChildtextarea);
            textarea.select();
            尝试 { 文档.execCommand('复制'); 提示('复制成功！'); } 捕获 (错误) { 提示('复制失败，请长按文本手动复制'); }
            文档.body.removeChild(textarea);
        }
    </脚本>
</正文>
</html>
