# Tailwind 类目速查（本项目实际使用）

本站用 [Tailwind CSS CDN](https://cdn.tailwindcss.com) + `css/tailwind-config.js`。  
类名写在 `class="..."` 里；不确定时，可按真实 CSS 属性名到 [Tailwind Docs](https://tailwindcss.com/docs) 搜索对应 utility。

---

## 类目目录

| # | 类目 | 对应真实 CSS 方向 |
|---|------|-------------------|
| 0 | [命名习惯](#0-命名习惯) | 前缀 / `x` `y` 含义 |
| 1 | [主题色与字体](#1-主题色与字体tailwind-configjs) | 自定义 token |
| 2 | [间距 Spacing](#2-间距-spacing) | margin / padding |
| 3 | [宽高与尺寸](#3-宽高与尺寸) | width / height / max-width |
| 4 | [布局 Layout](#4-布局-layout) | flex / grid / position |
| 5 | [文字 Typography](#5-文字-typography) | font / text / tracking |
| 6 | [颜色 · 边框 · 圆角 · 阴影](#6-颜色--边框--圆角--阴影) | color / border / radius |
| 7 | [图片](#7-图片) | object-fit |
| 8 | [交互与动效](#8-交互与动效) | hover / transition / filter |
| 9 | [响应式断点](#9-响应式断点) | sm / md / lg |
| 10 | [本站自写 CSS](#10-本站自写-css) | `styles.css` |
| 11 | [常用组合](#11-常用组合) | 读代码对照 |

---

## 0. 命名习惯

| 前缀 / 写法 | 含义 | 例 |
|-------------|------|-----|
| `m` | margin | `mt-4` → `margin-top` |
| `p` | padding | `px-4` → 左右 `padding` |
| **`x`** | 水平（left + right） | `px-4`、`mx-auto` |
| **`y`** | 垂直（top + bottom） | `py-2`、`my-4` |
| `t` / `r` / `b` / `l` | top / right / bottom / left | `mt-2`、`pb-10` |
| `w` / `h` | width / height | `w-full` |
| `text-` | 字色或字号 | `text-sm`、`text-white` |
| `bg-` | 背景 | `bg-white` |
| `border` | 边框 | `border-line` |
| `flex` / `grid` | 布局 | `flex`、`grid-cols-3` |
| `sm:` / `md:` / `lg:` | 响应式前缀 | `md:grid-cols-3` |
| `[...]` | 任意自定义值 | `max-w-[980px]`、`tracking-[0.2em]` |

间距刻度大致：`0.5`≈2px，`1`≈4px，`2`≈8px，`4`≈16px，`6`≈24px，`8`≈32px。

---

## 1. 主题色与字体（`tailwind-config.js`）

### 背景色

| 类名 | 作用 |
|------|------|
| `bg-dominos-blue` | 品牌蓝 `rgb(0, 144, 226)` |
| `bg-dominos-blue-deep` | 深蓝（hover） |
| `bg-dominos-red` | 品牌红 |
| `bg-cream` | 页面奶油底 |
| `bg-panel` | 浅米色面板（主题里有，页面较少用） |

### 文字色

| 类名 | 作用 |
|------|------|
| `text-dominos-blue` | 品牌蓝 |
| `text-dominos-red` | 品牌红 |
| `text-ink` | 正文深灰 |
| `text-muted` | 次要灰 |

### 边框色 · 字体族

| 类名 | 作用 |
|------|------|
| `border-line` | 浅灰分割线 |
| `font-display` | 标题字体 Oswald |
| `font-body` | 正文字体 Nunito Sans |

---

## 2. 间距 Spacing

### Margin（外边距）

| 类名 | CSS 含义 |
|------|----------|
| `mt-1` `mt-2` `mt-3` `mt-4` `mt-6` `mt-7` | `margin-top` |
| `mb-1` `mb-3` `mb-3.5` `mb-4` `mb-5` | `margin-bottom` |
| `mx-1` | 左右小间距 |
| `mx-auto` | 水平居中 |
| `ml-auto` | 推到右侧（如 Order Online 按钮） |

### Padding（内边距）

| 类名 | CSS 含义 |
|------|----------|
| `p-3.5` `p-5` | 四边 padding |
| `px-2` `px-3` `px-3.5` `px-4` `px-5` `px-6` | 左右（**x**） |
| `py-0.5` `py-1.5` `py-2` `py-2.5` `py-6` `py-8` `py-9` `py-10` | 上下（**y**） |
| `pt-4` `pt-7` | `padding-top` |
| `pb-4` `pb-6` `pb-10` | `padding-bottom` |

### Gap / Space（子元素间距）

| 类名 | 作用 |
|------|------|
| `gap-0.5` … `gap-8` | flex/grid 间距 |
| `gap-x-3` `gap-x-5` | 只设水平 gap |
| `gap-y-2` `gap-y-3` | 只设垂直 gap |
| `space-y-1` `space-y-4` | 子项之间垂直间距 |

---

## 3. 宽高与尺寸

| 类名 | 作用 |
|------|------|
| `w-full` `w-fit` `w-9` `w-max` | 宽度 |
| `h-full` `h-9` | 高度 |
| `min-w-0` `min-w-[320px]` | 最小宽度 |
| `min-h-[120px]` `min-h-[160px]` | 最小高度 |
| `max-w-[980px]` `max-w-[1100px]` `max-w-md` `max-w-sm` | 最大宽度 |
| `aspect-square` | 1:1 比例（产品图） |
| `basis-full` | flex basis 100% |
| `shrink-0` | 不被压缩 |

---

## 4. 布局 Layout

### Display · Flex · Grid

| 类名 | 作用 |
|------|------|
| `block` `inline-block` `hidden` | 显示方式 |
| `flex` `flex-1` `flex-col` `flex-wrap` `flex-nowrap` | Flex |
| `items-center` `items-start` | 交叉轴对齐 |
| `justify-between` `justify-center` | 主轴对齐 |
| `grid` | Grid |
| `md:grid-cols-2` `md:grid-cols-3` | 中屏列数 |
| `md:grid-cols-[0.9fr_1.1fr]` `md:grid-cols-[1.1fr_0.9fr]` | 自定义列比 |
| `lg:grid-cols-[1.2fr_1fr]` `lg:grid-rows-2` `lg:row-span-2` | 大屏首页促销栅格 |

### 定位 · 溢出 · 顺序

| 类名 | 作用 |
|------|------|
| `relative` `absolute` `inset-0` | 定位铺满 |
| `z-10` | 层级 |
| `overflow-hidden` `overflow-x-auto` | 裁切 / 横滚 |
| `order-2` `order-3` `md:order-none` | 视觉顺序（移动端导航） |

---

## 5. 文字 Typography

| 类名 | 作用 |
|------|------|
| `text-xs` `text-sm` `text-lg` `text-xl` `text-2xl` `text-3xl` `text-4xl` | 字号 |
| `sm:text-sm` `sm:text-4xl` `md:text-4xl` `md:text-5xl` | 响应式字号 |
| `text-center` `text-inherit` | 对齐 / 继承色 |
| `text-white` `text-white/75` `text-white/85` `text-white/90` | 白字 + 透明度 |
| `text-green-700` | 成功提示绿 |
| `uppercase` | 大写 |
| `tracking-wide` `tracking-wider` `tracking-widest` | 字间距 |
| `tracking-[0.14em]` `tracking-[0.18em]` `tracking-[0.2em]` | 自定义字间距 |
| `leading-relaxed` | 行高 |
| `no-underline` `underline` `underline-offset-2` `decoration-white/40` | 下划线 |
| `antialiased` | 字体平滑 |

---

## 6. 颜色 · 边框 · 圆角 · 阴影

| 类名 | 作用 |
|------|------|
| `bg-white` `bg-white/10` `bg-neutral-200` `bg-sky-50` | 内置背景 |
| `bg-gradient-to-r` `from-dominos-blue/85` `via-dominos-blue/55` `to-transparent` | 首页饮料横幅渐变 |
| `border` `border-t` | 边框 |
| `border-line` `border-green-600` `border-dominos-red` `border-white/35` | 边框色 |
| `rounded-sm` `rounded-md` `rounded-lg` `rounded-full` | 圆角 |
| `shadow-sm` `hover:shadow-lg` | 阴影 |

---

## 7. 图片

| 类名 | 作用 |
|------|------|
| `object-cover` | 裁切填满容器 |

---

## 8. 交互与动效

| 类名 | 作用 |
|------|------|
| `hover:bg-sky-50` `hover:bg-red-700` `hover:bg-dominos-blue-deep` `hover:bg-white/20` | 悬停背景 |
| `hover:text-dominos-red` `hover:text-white` `hover:underline` | 悬停文字 |
| `hover:border-white` `hover:-translate-y-0.5` `hover:shadow-lg` | 悬停边框 / 位移 / 阴影 |
| `group` | 父级，供 `group-hover:` |
| `group-hover:scale-[1.015]` `group-hover:scale-[1.02]` `group-hover:scale-[1.03]` | 悬停放大图 |
| `group-hover:brightness-105` `group-hover:saturate-110` | 产品图 filter |
| `transition` `duration-500` | 过渡 |
| `resize-y` | textarea 可纵向拖 |

---

## 9. 响应式断点

| 前缀 | 大约宽度 | 本站用途举例 |
|------|----------|--------------|
| `min-[375px]:` | ≥375px | 显示品牌字 |
| `sm:` | ≥640px | 按钮字号、横幅 padding |
| `md:` | ≥768px | 多列网格、导航换行取消 |
| `lg:` | ≥1024px | 首页促销大栅格 |

---

## 10. 本站自写 CSS

`css/styles.css`（不用一长串 utility 时放这里）：

| 类名 | 作用 |
|------|------|
| `.promo-btn` | 首页红色 Order Now 胶囊按钮 + hover |

---

## 11. 常用组合

```html
<!-- 页面主栏 -->
<main class="mx-auto max-w-[980px] px-4 pb-10">

<!-- 标题 -->
<h1 class="font-display text-3xl uppercase tracking-wide text-dominos-blue md:text-4xl">

<!-- 红按钮 -->
<a class="rounded-sm bg-dominos-red px-3 py-1.5 font-display text-sm uppercase tracking-wider text-white hover:bg-red-700">

<!-- 商店三列（手机一列） -->
<div class="grid gap-4 md:grid-cols-3">
```

官方文档：[https://tailwindcss.com/docs](https://tailwindcss.com/docs)
