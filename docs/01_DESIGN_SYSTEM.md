# Digital Library Design System
## Official Digital Library of Shaykh Fayez Al-Zahrani

Version: 1.0

---

# Purpose

This document defines the official UI/UX design system for the digital library.

It is the single source of truth for every frontend implementation.

Every page, component and interaction MUST follow these rules.

If any implementation conflicts with this document, this document always takes priority.

---

# Design Philosophy

The interface should feel:

- Modern
- Minimal
- Elegant
- Calm
- Academic
- Islamic
- Premium
- Fast

The website should never feel like:

- an online store
- a blog
- a news website
- a dashboard
- a template marketplace

It should feel like a modern digital Islamic library.

---

# Design Principles

Always prioritize

1. Simplicity
2. Readability
3. White Space
4. Accessibility
5. Consistency
6. Performance

Avoid visual noise.

Every element must have a purpose.

---

# RTL First

The entire application is designed RTL-first.

Never design LTR then flip it.

Required:

```html
<html lang="ar" dir="rtl">
```

Everything starts from the right.

Navigation.

Cards.

Icons.

Spacing.

Animations.

Everything.

---

# Target Audience

Arabic readers.

Students of knowledge.

Researchers.

General Muslims.

Age:

18+

Experience:

All technical levels.

---

# Responsive Strategy

Desktop First.

Supported breakpoints

Mobile

Tablet

Laptop

Desktop

Ultra Wide

The experience must feel native on every device.

---

# Color Palette

Primary

#1F5D43

Primary Hover

#184C37

Secondary

#5E8B6F

Accent

#D4AF37

Background

#FAFBF8

Surface

#FFFFFF

Border

#E7ECE8

Text Primary

#1F2937

Text Secondary

#6B7280

Success

#16A34A

Warning

#CA8A04

Danger

#DC2626

---

# Typography

Primary Font

Cairo

Fallback

IBM Plex Sans Arabic

Never mix multiple Arabic fonts.

Heading

Bold

Body

Regular

Use generous line height.

Arabic text must always be easy to read.

---

# Spacing System

Use 8px spacing.

Allowed spacing

4

8

12

16

24

32

40

48

64

80

96

Never use random spacing.

---

# Border Radius

Small

8px

Medium

12px

Large

16px

Extra Large

24px

Cards should feel soft.

Never sharp.

---

# Shadows

Very soft shadows only.

Never heavy shadows.

Cards should appear floating slightly above the background.

---

# Icons

Use one icon library only.

Recommended

Lucide Icons

Never mix icon libraries.

---

# Buttons

Primary

Solid Green

Secondary

White with Border

Ghost

Transparent

Danger

Red

Buttons must have:

Hover

Focus

Disabled

Loading

States.

---

# Inputs

Rounded.

Large.

Comfortable.

Always accessible.

Support:

Focus

Error

Disabled

Success

---

# Cards

Cards are the main UI element.

Every card must include:

Padding

Soft Radius

Light Shadow

Hover Animation

Never overload cards with information.

---

# Animations

Animations should feel natural.

Duration

150–300ms

Allowed

Fade

Scale

Slide

Opacity

Never use:

Bounce

Flash

Shake

Spinning animations

Large transforms

---

# Images

Book covers should always:

Maintain aspect ratio.

Use lazy loading.

Have rounded corners.

Never stretch.

---

# Accessibility

WCAG AA minimum.

Keyboard accessible.

Visible focus state.

Proper labels.

Proper contrast.

Semantic HTML.

---

# Performance

Optimize for performance.

Prefer CSS over JavaScript.

Lazy load images.

Avoid unnecessary dependencies.

Avoid large bundles.

---

# Components

Reusable components only.

Examples

Button

Card

Input

Badge

Stat Card

Section Title

Container

Pagination

Search Input

No duplicated UI.

---

# Layout

Consistent page width.

Centered container.

Large white space.

Comfortable reading experience.

---

# Homepage Structure

Navbar

↓

Hero

↓

Statistics

↓

Search

↓

Books Grid

↓

Pagination

↓

Footer

Only this structure.

---

# Book Page Structure

Book Header

↓

Book Details

↓

Actions

↓

PDF Reader

↓

Private Message Form

↓

Footer

---

# Admin Panel

Admin uses the same color system.

Not necessarily the same layout.

Dashboard should focus on data.

---

# Tone

Professional.

Trustworthy.

Calm.

Academic.

Elegant.

Never playful.

---

# What To Avoid

Do not use Bootstrap.

Do not use jQuery.

Do not use unnecessary gradients.

Do not use glassmorphism.

Do not use excessive animations.

Do not use random colors.

Do not use inconsistent spacing.

Do not create duplicated components.

Do not modify backend logic unless requested.

---

# Definition of Done

Every implemented component must be:

RTL

Responsive

Accessible

Reusable

Consistent

Pixel-perfect

Performance friendly

Clean code

Production ready

---

End of Document.