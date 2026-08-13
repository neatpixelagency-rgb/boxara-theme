# Boxara — session record, 12 August 2026

Everything done in this session, why, and what is left broken. Written as a
handover so the next session — whoever runs it — does not have to reconstruct it.

---

## 0. Read this first

**Nothing is committed.** `git log` shows one commit: `d0e563d Underscores scaffold
with WooCommerce support`. Every file below is an uncommitted working-tree change.

```
 M footer.php
 M functions.php
 M header.php
?? assets/
?? front-page.php
?? inc/icons.php
?? inc/site-chrome.php
?? patterns/
?? theme.json
```

If that working tree is lost, the whole session is lost. Commit before anything else.

**Also changed outside this repo:** the Figma file was edited (section 2) and
WordPress settings were inspected (section 5). Those are not in Git.

---

## 1. What the session set out to do

Phase 7 of the build order — `theme.json` from the Figma design tokens — then
header/footer, then the homepage. It got through tokens, fonts, header, footer
and one homepage section before stopping.

---

## 2. Changes made to the Figma file

**These are real edits to `Boxara Website redesign` (`FWb2qPbH2DemBji6nPBAC3`).**
Figma version history can revert them.

### Why

The file had 24 colour variables, 11 of them greys spanning three unrelated ramps
(warm, neutral, cool). Contrast was measured against `bg-primary` `#0a0a0a`:

| Variable | Hex | Ratio | Verdict |
|---|---|---|---|
| `text-ghost` | `#333333` | **1.57** | Fails at any size — was on "Privacy Policy" and "Terms of Service" at 10px |
| `text-subtle` | `#4d4d4d` | **2.34** | Fails at any size — 15 text nodes at 10px, footer and contact details |
| `text-faint` | `#666666` | 3.45 | Fails body text |
| `stroke-subtle` | `#0d0d0d` | 1.02 | Invisible as a border — 24 uses |

WCAG AA needs 4.5:1 for body text, 3:1 for large.

### What was actually changed

1. **52 text nodes rebound** off the failing and duplicate greys onto the surviving
   warm ramp. Privacy Policy / Terms went 1.57 → 6.04.
2. **24 frame borders** repointed `stroke-subtle` → `stroke-muted`.
3. **6 variables deleted** after confirming zero remaining bindings:
   `text-ghost`, `text-subtle`, `text-faint`, `text-neutral`, `text-cool`,
   `text-accent-cool`.
4. **`stroke-subtle` renamed to `bg-sunken`** and rescoped to `FRAME_FILL`,
   `SHAPE_FILL`. Its 8 legitimate background-fill uses kept the exact value
   `#0d0d0d`, so there is **no visual change** there — only the name and the 24
   invisible borders changed.
5. **`text-disabled` revalued** `#808080` → `#78766f` so it sits on the warm ramp.
   It is now unused, reserved for genuine disabled states.
6. **`color/brand-ink` `#0a0a0a` created** — the text colour for use on the orange.
7. **Scopes set on all 19 colour variables.** They were all `ALL_SCOPES`, which
   offers every colour in every picker. Now text colours only offer themselves to
   text, backgrounds to frames, strokes to strokes.

### Result

19 colour variables, **0 orphaned bindings**, every colour in use passes WCAG AA.

### Not changed, deliberately — still open

- **Buttons in Figma are still white text on orange.** That is **3.49:1 and fails**.
  Black on the same orange is 5.67:1. The code already uses the dark version; the
  design file does not.
- **`accent-teal`, `accent-crimson`, `brand-dark`** have zero uses. Keep or delete?
- **Text at 9px and 10px** exists across the design. Too small for production
  regardless of contrast.
- The desktop nav icon is **named `Icon-search` but drawn as a shopping cart**.

---

## 3. Design tokens — what was found and what was built

### Found in Figma

Better than expected. Typography was already a proper variable system: 56 variables
across `font-size` (25), `line-height` (14), `letter-spacing` (9), `font-family` (4),
`font-weight` (4). The ~70 text styles are just combinations of those.

**No spacing, radius or shadow variables existed.** Those were derived by measuring
the frames: gaps and padding cluster cleanly on a **4px grid**
(4/8/12/16/20/24/32/40/48/64/80/96). Container is **1280** inside a **1440** frame.
Mobile gutter **24**, desktop gutter **80**. Radii 2/4/8/12/16/20/24/pill.

### Built — `theme.json` (version 3)

WordPress is **7.0.3**, so v3 and `fontFace` are both fully supported.

**Exposed to the client**, deliberately short:

- 8 colours, `custom: false`, WordPress defaults disabled — no freeform picker
- 8 font sizes, **fluid** (`clamp()`), so one scale covers mobile → desktop
- 12 spacing steps

**Available in CSS only**, under `settings.custom` — 19 colours, 22 font sizes,
15 line heights, 9 letter spacings, 8 radii, 3 container values.

Also set: `h1`–`h6` mapped to the display scale, links in brand orange, buttons
using `brand-ink` on orange.

Verified: 44 CSS custom properties used across the stylesheets, **all resolve** to
tokens that exist.

---

## 4. Fonts

Self-hosted, 25 `.woff2` files in `assets/fonts/`, **476 KB total**, declared as
25 `fontFace` entries in `theme.json`. No CDN link — GDPR and performance.

| Family | Role | Weights | Size |
|---|---|---|---|
| Bebas Neue | display | 400 | 28 KB |
| Manrope | body | 400/600/700 | 108 KB |
| Montserrat | labels, buttons | 400/600/700/800 | 268 KB |
| Allison | script accent | 400 | 72 KB |

Sourced via npm (`@fontsource/*`) because the sandbox can reach the npm registry.

**Subsets:** latin + latin-ext. Serbian diacritics (č ć š ž đ) live in **latin-ext**,
not latin — shipping only latin would have broken every Serbian word mid-string.
`unicode-range` means a browser only downloads the subsets a page actually uses.

**Cyrillic:** Manrope and Montserrat include it. **Bebas Neue and Allison have no
Cyrillic glyphs at all.** Decision taken: site is Latin-only Serbian and the
`serbian-transliteration` plugin gets dropped. If that reverses, every heading
falls back to a system font in Cyrillic mode.

**Two open cost questions:**

- Montserrat is **268 KB — 56% of the font payload** — and only draws labels and
  buttons. Manrope already ships 400/600/700 and could do that job.
- Allison is **72 KB** for a handful of decorative words.

---

## 5. WordPress state discovered

| | |
|---|---|
| WordPress | 7.0.3 |
| Homepage was set to | **`Prodavnica`** — the old Elementor product-grid homepage |
| WooCommerce shop page | **`Shop`** |
| Cart / Checkout / My account | IDs 144 / 145 / 146 |
| Terms and conditions | **not set** |

`Prodavnica` and `Shop` are two different pages. `Prodavnica` is the legacy
homepage; `Shop` is what WooCommerce actually points at. Recommendation was to
leave both alone until the shop template exists, then consolidate the slug to
`/prodavnica/`.

Nothing was deleted or renamed.

---

## 6. Files created and modified in the theme

### Created

| File | What it is |
|---|---|
| `theme.json` | Design tokens, fluid type, 25 fontFace declarations |
| `assets/fonts/` | 25 woff2 files |
| `front-page.php` | Thin — renders `the_content()` full-width for the block-built homepage |
| `inc/icons.php` | `boxara_icon()` — inlines SVGs from `assets/icons/`, `wp_kses`-safe, returns empty string if a file is missing so a bad export never fatals |
| `inc/site-chrome.php` | Logo, cart link with count badge, social links, Customizer social fields, WooCommerce AJAX cart fragment |
| `assets/css/site-chrome.css` | Header, footer, mobile drawer |
| `assets/css/home.css` | Homepage sections |
| `assets/js/site-chrome.js` | Mobile drawer — Escape, backdrop click, focus trap, scroll lock, `prefers-reduced-motion` |
| `patterns/home-hero.php` | Hero as a Gutenberg block pattern |
| `assets/icons/README.md` | Export spec for the 6 missing icons |

### Rewritten

- **`header.php`** — logo, centred primary nav, cart, mobile hamburger + drawer
- **`footer.php`** — brand column, three link columns, social, legal bar

### Modified

- **`functions.php`** — registered 5 nav menus (`menu-1`, `footer-shop`,
  `footer-company`, `footer-help`, `footer-legal`); added WooCommerce theme
  support; `align-wide`, `responsive-embeds`, editor styles; registered the
  `boxara-home` pattern category; replaced the Underscores navigation script with
  `site-chrome.js`; enqueued the two new stylesheets

### Deleted by Nikola at end of session

- `CLAUDE.md` — project context for Claude Code
- `docs/tasks/01-figma-assets.md` — the Figma asset-import task, including a
  manifest of all 18 unique homepage images with node IDs

That manifest is reproduced in section 9 so it does not have to be regenerated.

---

## 7. Mistakes made this session

Recorded honestly, because they cost time and could repeat.

1. **Proposed hand-coding the homepage.** The brief says home/about/contact are
   Gutenberg. It was suggested they be hand-coded for animation fidelity. Nikola
   caught it. Corrected to block patterns — which is the right answer, and is what
   `patterns/home-hero.php` is.

2. **A stacking bug in the hero scrim.** The gradient was painted as an `::after`
   overlay that sat above the content instead of behind it, so the hero rendered as
   a black box with the copy invisible. It was repointed onto the cover block's own
   background span. **This fix is unverified** — see section 8.

3. **The first variable-usage scan double-counted.** It reported 30 uses of
   `text-subtle` and 64 of `stroke-subtle`; the real figures were 15 and 32. Caught
   and corrected before anything was deleted, but the first numbers were wrong.

4. **Layout was written blind.** No browser access, no rendered page, ever. CSS was
   written from Figma coordinates. That is the root cause of #2 and of the homepage
   not matching the design on first attempt.

---

## 8. What is broken or unfinished right now

- **`assets/icons/` is empty** apart from the README. The header cart and hamburger
  render nothing. 6 SVGs needed: `cart`, `menu`, `close`, `instagram`, `facebook`,
  `pinterest`. `close.svg` **has no node in the Figma file** — the mobile drawer
  needs a close state that was never designed.
- **The hero pattern's scrim markup changed after it had already been inserted**
  into the Početna page. The saved page content may still carry the old classes
  (`has-background-dim-0 has-background-dim`) while the CSS now targets
  `.home-hero__scrim`. Either re-insert the pattern or make the CSS cover both.
- **The scrim fix has never been seen rendered.** Treat it as unverified.
- **7 of 8 homepage sections are not built** — collections, product showcase,
  custom-made, features, testimonials, store location, newsletter.
- **No WooCommerce templates.** The shop page renders stock Woo markup with no
  styling. This is expected, not a bug.
- **No hero image.** The homepage will not resemble the design until it is in.
- **No `/po-meri/` page**, so the hero's second CTA 404s.
- **`js/navigation.js`** is no longer enqueued and can be deleted.

---

## 9. The homepage image manifest

Scanned from both landing frames: **42 image fills, 18 unique images.** Several are
reused across breakpoints — each should be downloaded once at its largest size.

| # | Suggested name | Section | Node | Largest size | Uses |
|---|---|---|---|---|---|
| 1 | `boxara-logo` | Nav + Footer, both | `190:139` | 116×32 | 4 |
| 2 | `hero-artwork` | Hero | `112:46` | 1440×809 | 4 |
| 3 | `collection-astronaut` | Collections | `111:3683` | 296×196 | 5 |
| 4 | `product-01` | Products-Showcase | `111:3693` | 302×260 | 3 |
| 5 | `product-02` | Products-Showcase | `111:3702` | 302×260 | 3 |
| 6 | `product-03` | Products-Showcase | `111:3720` | 302×260 | 3 |
| 7 | `texture-grain` | Custom-Made | `112:127` | 1440×834 | 2 |
| 8 | `custom-made` | Custom-Made | `190:132` | 540×425 | 2 |
| 9 | `feature-craft-hands` | Features | `112:169` | 616×380 | 2 |
| 10 | `feature-premium-frames` | Features | `112:173` | 616×380 | 2 |
| 11 | `avatar-01` | Testimonial | `112:195` | 44×44 | 2 |
| 12 | `avatar-02` | Testimonial | `112:213` | 44×44 | 3 |
| 13 | `store-front` | Store-Location | `112:222` | 608×360 | 2 |
| 14 | `mobile-hero-detail` | mobile only | `118:4480` | 200×204 | 1 |
| 15 | `mobile-product-01` | mobile only | `118:4539` | 156×152 | 1 |
| 16 | `mobile-product-02` | mobile only | `118:4549` | 156×152 | 1 |
| 17 | `mobile-craft-hands` | mobile only | `118:4605` | 327×256 | 1 |
| 18 | `mobile-premium-frames` | mobile only | `118:4612` | 327×256 | 1 |

**17 and 18 may be the same source images as 9 and 10** at a different crop —
compare before importing twice.

When downloading via the Figma MCP, use **`rawImages`, not `export`**. The export
is a flattened render of the whole frame *including the headline text and gradient
overlay*; the raw image is the original photograph.

---

## 10. Environment limits found

These are why several things could not be finished here, and are worth knowing
before assigning work.

Network reachability was tested directly from the sandbox:

| Host | Result |
|---|---|
| registry.npmjs.org | reachable |
| pypi.org | reachable |
| github.com | reachable |
| **www.figma.com** | **blocked** |
| example.com | blocked |

So the sandbox is on an **allowlist** — package registries and GitHub only. That is
why the fonts could be installed via npm but Figma's asset host could not be
reached, and therefore why **no image or icon could be downloaded**.

Also unavailable in this environment:

- **WP-CLI** — it lives on the Mac, not in the sandbox
- **Media Library writes** — an upload needs a database attachment record and
  generated thumbnails, which requires WP-CLI or wp-admin
- **A browser** — no way to see a rendered page

Claude Code running in a terminal has none of these limits: it runs as a process on
the Mac with normal network access and a working `wp` binary. The difference is
purely *where the code executes*, not model, permissions or project rules.

---

## 11. Decisions taken, for the record

| Decision | Outcome |
|---|---|
| Colour ramps | Consolidated in Figma first, so the design file and code stay in sync |
| Type scale | Extracted from existing Figma variables; text styles left alone |
| Spacing | Derived by measuring frames — 4px grid |
| Cyrillic | **Latin only.** Drop `serbian-transliteration` |
| Homepage build method | **Gutenberg block patterns**, not hardcoded PHP |
| Button contrast | Code uses `brand-ink` on orange; Figma not yet updated |
| Shop page slug | Leave alone until WooCommerce templates exist |
| Execution environment | Moving to Claude Code in the terminal for Figma pulls and media imports |

---

## 12. Suggested next steps

1. **Commit the working tree.** Everything above is unsaved history.
2. Get the 18 images and 6 icons out of Figma and into the Media Library.
3. Verify the hero renders — with a real image — before building section 2.
4. Decide the three open Figma questions: button contrast, unused accent colours,
   9–10px text.
5. Then sections 2–8, then WooCommerce templates, then animation last.

Still missing from the design entirely: **a single-product page** and a **desktop
shop layout**. The product page is where the money is made, and there is no design
for it.
