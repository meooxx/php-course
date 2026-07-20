# Tailwind 类名速查（本项目实际使用）

本站用 [Tailwind CSS CDN](https://cdn.tailwindcss.com) + `css/tailwind-config.js` 自定义主题。  
类名写在 HTML/`class="..."` 里，大致对应一段 CSS。

命名习惯（多数工具类）：

| 前缀 | 含义 | 例 |
|------|------|-----|
| `m` | margin | `mt-4` = margin-top |
| `p` | padding | `px-4` = 左右 padding |
| `w` / `h` | width / height | `w-full` = 100% 宽 |
| `text-` | 文字颜色或字号 | `text-sm`、`text-white` |
| `bg-` | 背景色 | `bg-white` |
| `border` | 边框 | `border-line` |
| `flex` / `grid` | 布局 | `flex`, `grid-cols-3` |
| `md:` / `lg:` / `sm:` | 响应式断点 | `md:grid-cols-3` 仅 ≥768px 生效 |

间距数字大致：`0.5`≈2px，`1`≈4px，`2`≈8px，`4`≈16px，`6`≈24px，`8`≈32px。

---

## 1. 自定义主题色 / 字体（`tailwind-config.js`）

| 类名 | 作用 |
|------|------|
| `bg-dominos-blue` | 背景：品牌蓝 `rgb(0, 144, 226)` |
| `bg-dominos-blue-deep` | 背景：深蓝（hover） |
| `bg-dominos-red` | 背景：品牌红 |
| `bg-cream` | 背景：奶油色页面底 |
| `bg-panel` | 背景：浅米色面板 |
| `text-dominos-blue` | 文字：品牌蓝 |
| `text-dominos-red` | 文字：品牌红 |
| `text-ink` | 文字：深灰正文色 |
| `text-muted` | 文字：次要灰 |
| `border-line` | 边框色：浅灰线 |
| `font-display` | 标题字体 Oswald |
| `font-body` | 正文字体 Nunito Sans |

---

## 2. 间距 Spacing

### Margin

| 类名 | CSS 含义 | 说明 |
|------|----------|------|
| `m-0` | margin: 0 | 四边无外边距 |
| `mt-1` | margin-top | 上外边距 |
| `mt-2` / `mt-3` / `mt-4` / `mt-6` | margin-top | 上间距从小到大 |
| `mb-1` / `mb-2` / `mb-3` / `mb-3.5` / `mb-4` / `mb-5` / `mb-8` | margin-bottom | 下外边距 |
| `mx-auto` | margin-left/right: auto | 水平居中块级容器 |

### Padding

| 类名 | CSS 含义 | 说明 |
|------|----------|------|
| `p-0` | padding: 0 | 无内边距 |
| `p-3.5` / `p-4` / `p-5` | padding | 四边内边距 |
| `px-2` / `px-3` / `px-4` / `px-5` / `px-6` | padding-left + right | 左右内边距 |
| `py-0.5` / `py-1.5` / `py-2` / `py-6` / `py-8` / `py-10` | padding-top + bottom | 上下内边距 |
| `pt-7` | padding-top | 上内边距 |
| `pb-4` / `pb-6` / `pb-10` | padding-bottom | 下内边距 |
| `sm:px-10` | ≥640px 时左右 padding 加大 | 响应式 |

---

## 3. 宽高与尺寸

| 类名 | 作用 |
|------|------|
| `w-full` | width: 100% |
| `w-fit` | width: fit-content（随内容） |
| `h-full` | height: 100% |
| `h-9` / `w-9` | 固定宽高（logo 约 2.25rem） |
| `min-h-14` | 最小高度（导航栏） |
| `min-h-[160px]` | 任意最小高度（方括号 = 自定义值） |
| `min-h-[120px]` | textarea 最小高度 |
| `min-w-[640px]` | 表格最小宽度，配合横向滚动 |
| `max-w-[980px]` / `max-w-[1100px]` / `max-w-md` | 最大宽度，限制内容栏 |
| `aspect-square` | 宽高比 1:1（产品图） |

---

## 4. 布局 Layout

| 类名 | 作用 |
|------|------|
| `block` | display: block |
| `inline-block` | display: inline-block（按钮/徽章可设宽高） |
| `flex` | 弹性布局 |
| `flex-1` | 占满剩余空间 |
| `flex-col` | 纵向排列 |
| `flex-wrap` | 允许换行 |
| `items-center` | 交叉轴居中（垂直居中于 flex 行） |
| `items-start` / `items-end` | 交叉轴顶/底对齐 |
| `justify-between` | 主轴两端对齐 |
| `justify-center` | 主轴居中 |
| `gap-0.5` / `gap-1.5` / `gap-2` / `gap-3` / `gap-4` / `gap-5` / `gap-6` | flex/grid 子项间距 |
| `grid` | CSS Grid |
| `grid-cols-3` | 三列（需配合断点） |
| `md:grid-cols-2` / `md:grid-cols-3` | ≥768px 时 2/3 列 |
| `md:grid-cols-[1.1fr_0.9fr]` | 自定义列宽比例 |
| `lg:grid-cols-[1.2fr_1fr]` | ≥1024px 首页促销两列 |
| `lg:grid-rows-2` / `lg:row-span-2` | 大屏两行；左卡跨两行 |
| `space-y-4` | 子元素之间垂直间距（列表） |
| `relative` / `absolute` | 定位上下文 / 绝对定位 |
| `inset-0` | top/right/bottom/left: 0（铺满父级） |
| `z-10` | 层级，盖在背景图上 |
| `overflow-hidden` | 裁切溢出（圆角图） |
| `overflow-x-auto` | 横向滚动（宽表格） |

---

## 5. 文字 Typography

| 类名 | 作用 |
|------|------|
| `text-xs` / `text-sm` / `text-lg` / `text-xl` / `text-2xl` / `text-3xl` / `text-4xl` | 字号从小到大 |
| `md:text-4xl` / `sm:text-4xl` | 大屏更大标题 |
| `text-left` / `text-center` | 对齐 |
| `text-white` / `text-white/85` / `text-white/90` | 白色及透明度 |
| `text-inherit` | 继承父级颜色 |
| `text-green-700` | 成功绿 |
| `font-bold` | font-weight: 700 |
| `uppercase` | 全部大写 |
| `tracking-wide` / `tracking-wider` / `tracking-widest` | 字间距 |
| `tracking-[0.2em]` | 自定义字间距 |
| `no-underline` | 去掉下划线 |
| `underline-offset-2` | 下划线偏移（配合 hover:underline） |
| `antialiased` | 字体平滑 |

---

## 6. 颜色 / 边框 / 圆角 / 阴影

| 类名 | 作用 |
|------|------|
| `bg-white` / `bg-neutral-200` / `bg-sky-50` / `bg-black/20` | 背景色（含半透明） |
| `bg-accent-blue` | 主题里若未定义可能不生效；项目多用 `dominos-blue` |
| `bg-gradient-to-r` | 从左到右渐变 |
| `from-dominos-blue/85` `via-dominos-blue/55` `to-transparent` | 渐变起止色 |
| `border` / `border-0` / `border-2` | 边框宽度 |
| `border-t` | 仅上边框（表格行分隔） |
| `border-line` / `border-green-600` / `border-dominos-red` | 边框颜色 |
| `rounded-sm` / `rounded-md` / `rounded-lg` / `rounded-full` | 圆角（full = 胶囊按钮） |
| `shadow-sm` | 轻阴影 |

---

## 7. 图片与对象

| 类名 | 作用 |
|------|------|
| `object-cover` | 图片裁切填满容器，保持比例 |
| `object-center` | 裁切焦点居中 |

---

## 8. 交互与状态

| 类名 | 作用 |
|------|------|
| `hover:bg-black/20` | 悬停：半透明黑底（导航） |
| `hover:bg-sky-50` | 悬停：浅蓝底 |
| `hover:bg-red-700` / `hover:bg-dominos-blue-deep` | 悬停加深按钮 |
| `hover:text-dominos-red` / `hover:text-white` | 悬停改字色 |
| `hover:underline` | 悬停显示下划线 |
| `group` | 父级标记，供子级 `group-hover:` 用 |
| `group-hover:scale-[1.02]` | 父悬停时子图轻微放大 |
| `transition` / `duration-500` | 过渡动画时长 |
| `cursor-pointer` | 鼠标手型 |
| `resize-y` | textarea 仅纵向可拖 |

---

## 9. 无障碍 / 杂项

| 类名 | 作用 |
|------|------|
| `sr-only` | 视觉隐藏，屏幕阅读器仍可读 |

---

## 10. 非 Tailwind（本站自写 CSS）

在 `css/styles.css`：

| 类名 | 作用 |
|------|------|
| `.option-chip` | 选项标签；选中时改边框/背景 |
| `.promo-btn` | 首页红色「Order Now」胶囊按钮 |

---

## 常用组合（读代码时对照）

```html
<!-- 页面主栏：居中 + 最大宽度 + 左右内边距 -->
<main class="mx-auto max-w-[980px] px-4 pb-10">

<!-- 标题 -->
<h1 class="font-display text-3xl uppercase tracking-wide text-dominos-blue md:text-4xl">

<!-- 红按钮 -->
<a class="bg-dominos-red px-3 py-1.5 font-display text-sm uppercase tracking-wider text-white rounded-sm">

<!-- 三列菜单（手机一列，中屏三列） -->
<div class="grid gap-4 md:grid-cols-3">
```

更全的官方说明：[Tailwind Docs](https://tailwindcss.com/docs)。
