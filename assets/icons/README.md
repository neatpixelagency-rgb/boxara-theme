# Icons

Inline SVGs exported from the Figma file, loaded by `boxara_icon( 'name' )`
(see `inc/icons.php`). A missing file renders nothing rather than erroring.

## Required exports

Export each as **SVG** from `Boxara Website redesign`, save here with the
exact filename below.

| Filename         | Figma node   | Where it came from        | Used in |
|------------------|--------------|---------------------------|---------|
| `cart.svg`       | `112:42`     | Desktop Nav → Icon-search | Header cart link |
| `menu.svg`       | `118:4436`   | Mobile Nav → Img          | Header hamburger |
| `close.svg`      | —            | Hand-authored, not in Figma | Drawer close state |
| `instagram.svg`  | `112:285`    | Footer → Icon-instagram   | Footer social |
| `facebook.svg`   | `112:288`    | Footer → Icon-facebook    | Footer social |
| `pinterest.svg`  | `112:291`    | Footer → Icon-pinterest   | Footer social |

All six are exported and in place. `close.svg` has no node in the Figma
file, so it's a plain hand-drawn 24×24 X instead — worth designing properly
in Figma later.

## Export settings

- Format **SVG**
- **Outline text** off (there is no text in these)
- **Include "id" attribute** off — keeps the markup clean

## Colour

Icons inherit colour from CSS via `fill: currentColor`. After exporting,
replace any hard-coded `fill="#..."` with `fill="currentColor"`, or delete
the `fill` attribute entirely. Otherwise hover states will not work.

Note the desktop nav icon is *named* `Icon-search` in Figma but is drawn as a
shopping cart. It is used here as the cart link. Worth renaming in Figma.
