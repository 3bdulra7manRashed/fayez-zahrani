# Project Rules
## Official Digital Library of Shaykh Fayez Al-Zahrani

Version: 1.0

---

# Purpose

This document defines the development rules for the project.

These rules are mandatory.

If a task conflicts with these rules, these rules take precedence.

---

# Project Goal

Redesign and modernize the frontend UI/UX of the official digital library while preserving the existing backend architecture.

Backend is considered production-ready.

---

# Scope

Allowed:

- Blade
- Livewire
- Tailwind CSS v4
- Alpine.js
- CSS
- HTML
- Responsive improvements
- Accessibility improvements
- UI Components
- UX improvements

Forbidden:

- Refactor backend
- Change business logic
- Rename Models
- Rename Controllers
- Rename Routes
- Rename Database Tables
- Rename Livewire Components
- Install unnecessary packages
- Rewrite Filament Resources

---

# Working Style

Work incrementally.

One task at a time.

Never continue automatically.

Wait for review before starting the next task.

---

# Existing Code

Treat all backend code as production-ready.

If you discover a bug:

1. Explain it.
2. Suggest a solution.
3. Wait for approval.

Never implement backend changes without permission.

---

# Component Rules

Every UI element must be reusable.

Avoid duplicated Blade markup.

Extract reusable components whenever appropriate.

---

# Livewire Rules

One responsibility per component.

Keep components small.

Business logic belongs inside PHP.

Views should remain presentation only.

---

# Styling Rules

Never use inline styles.

Never duplicate CSS.

Always use design tokens defined in DESIGN_SYSTEM.md.

---

# Accessibility

Every new UI must support:

- Keyboard navigation
- Focus states
- Proper labels
- Semantic HTML
- Color contrast

Minimum WCAG AA.

---

# Performance

Prefer CSS over JavaScript.

Lazy load images.

Avoid unnecessary queries.

Avoid N+1.

Use pagination.

---

# Code Quality

Follow PSR-12.

Keep methods short.

Prefer readable code.

Avoid clever code.

Document non-obvious decisions.

---

# Output Format

Every completed task must include:

- Files Created
- Files Modified
- Components Added
- Notes
- Testing Required
- Ready For Review

---

# Stop Conditions

After completing the requested task:

STOP.

Do not continue.

Wait for the next instruction.

---

End of Document.