# Guía de Implementación Elementor — BetterSEO Landing
> Requiere: Elementor Pro · Tema hijo activo

---

## Checklist previo (antes de tocar Elementor)

- [ ] Hacer backup de la página actual
- [ ] Tener los 4 screenshots exportados como PNG (1456x816px mínimo)
- [ ] Confirmar colores en el kit de Elementor: `#3a4655` y `#93abc2`
- [ ] Confirmar fuente del kit (H1/H2 y body)
- [ ] Subir logos de clientes a la Media Library

---

## Configuración de la página (Settings de Elementor)

Antes de agregar secciones, configurar en **Page Settings** (ícono de engranaje):

| Setting | Valor |
|---------|-------|
| Page Layout | Elementor Full Width |
| Hide Title | Sí (el H1 va en la sección Hero) |
| Body Background | `#ffffff` |

---

## SECCIÓN 1 — HERO

**Estructura:** 1 Section → 2 Columns (60% / 40%)

### Column izquierda (60%)
| Widget | Contenido |
|--------|-----------|
| Heading | Tag: `p`, Style: uppercase, color `#93abc2`, font 12px, letter-spacing 2px → texto: `SEO + AEO + GEO PARA WINERIES` |
| Heading | Tag: `h1`, color `#3a4655`, font 52px, bold → texto: `Tu producto existe. Google — y la IA — no lo saben todavía.` |
| Text Editor | Body copy del Hero (ver copy-landing.md §1) |
| Button | Primario: `Get Started — $30/mo`, fondo `#3a4655`, texto blanco |
| Button | Secundario: `See How It Works ↓`, sin fondo, borde `#3a4655` |
| Icon List | 4 trust indicators con ✓ como icono, color `#93abc2`, font 14px |

### Column derecha (40%)
| Widget | Contenido |
|--------|-----------|
| Image | Screenshot before/after Open Graph (slide 1) |

### Section Style
- Padding top/bottom: `80px`
- Min height: `85vh`
- Vertical align: middle

---

## SECCIÓN 2 — PAIN POINT

**Estructura:** 1 Section → 1 Column centrada (max-width 800px via Inner Section o Container)

### Fondo
- Background: `#f4f6f8`
- Padding: `80px 20px`

### Widgets
| Widget | Config |
|--------|--------|
| Heading | H2, centrado, `#3a4655`, 38px → `La búsqueda cambió. Los catálogos de vino, no.` |
| Text Editor | 3 párrafos del copy (ver §2), 16px, line-height 1.8, max-width 720px, centrado |

---

## SECCIÓN 3 — CÓMO FUNCIONA

**Estructura:** 1 Section → headline + Inner Section con 3 columnas iguales

### Fondo
- Background: blanco
- Padding: `80px 20px`

### Row 1 — Headline
| Widget | Config |
|--------|--------|
| Heading | H2, centrado, `#3a4655` → `Tres pasos. Cero código.` |

### Row 2 — 3 columnas
Cada columna contiene:
| Widget | Config |
|--------|--------|
| Heading | Tag `p`, font 48px, bold, color `#93abc2` → `01` / `02` / `03` |
| Heading | H3, `#3a4655`, 20px → título del paso |
| Text Editor | Descripción del paso, 15px, `#3a4655` al 70% |

**Animación (Elementor Motion):** Entrance → Fade In Up, delay escalonado (0 / 200ms / 400ms)

---

## SECCIÓN 4 — FEATURES

**Estructura:** Repetir 4 veces el patrón "imagen + texto", alternando la posición (imagen izquierda / imagen derecha)

### Fondo alternado
- Features 1, 3: fondo `#f4f6f8`
- Features 2, 4: fondo blanco
- **Excepción:** Feature 4 (AI Engines) → fondo `#3a4655`, todo texto blanco

### Estructura de cada feature (2 columnas 50/50)
| Widget | Config |
|--------|--------|
| Image | Screenshot correspondiente, border-radius 12px, box-shadow suave |
| Heading | H3, 26px, bold, color según fondo |
| Text Editor | Body copy de la feature |
| Icon List | Tags/badges de la feature — usar Custom HTML si se quiere estilo de chips |

### Chips/badges HTML para tags
```html
<div style="display:flex; flex-wrap:wrap; gap:8px; margin-top:16px;">
  <span style="background:#f4f6f8; color:#3a4655; padding:4px 12px; border-radius:20px; font-size:12px; font-weight:600; letter-spacing:1px; text-transform:uppercase;">og:title</span>
  <span style="background:#f4f6f8; color:#3a4655; padding:4px 12px; border-radius:20px; font-size:12px; font-weight:600; letter-spacing:1px; text-transform:uppercase;">og:image</span>
  <!-- repetir para cada tag -->
</div>
```
> Para Feature 4 (fondo oscuro): cambiar background a `rgba(255,255,255,0.12)` y color a `#ffffff`

---

## SECCIÓN 5 — SOCIAL PROOF

**Estructura:** 1 Section → headline + logo carousel + quote card

### Fondo
- Background: blanco
- Padding: `60px 20px`

### Widgets
| Widget | Config |
|--------|--------|
| Heading | Pequeño, uppercase, color `#93abc2` → trust label |
| Logo Carousel | Elementor Pro widget `Logo Carousel` con logos de clientes en gris, al hover full color |
| Testimonial | Elementor widget Testimonial, o custom HTML card con la quote |

### Quote card HTML (si no se usa widget nativo)
```html
<div style="background:#f4f6f8; border-left:4px solid #3a4655; padding:32px; border-radius:8px; max-width:700px; margin:0 auto;">
  <p style="font-size:18px; line-height:1.8; color:#3a4655; font-style:italic; margin:0 0 20px;">
    "[Quote del cliente]"
  </p>
  <div style="display:flex; align-items:center; gap:12px;">
    <img src="[foto]" style="width:48px; height:48px; border-radius:50%; object-fit:cover;" />
    <div>
      <strong style="color:#3a4655; display:block;">[Nombre]</strong>
      <span style="color:#93abc2; font-size:14px;">[Cargo] — [Winery]</span>
    </div>
  </div>
</div>
```

---

## SECCIÓN 6 — PRICING

**Estructura:** 1 Section → 2 columnas (pricing card principal + add-on card)

### Fondo
- Background: `#f4f6f8`
- Padding: `80px 20px`

### Card Principal — $30/mes
| Widget | Config |
|--------|--------|
| Heading | Precio `$30`, font 56px, bold, color `#3a4655` |
| Text Editor | `/mes · Sin contrato`, 14px, gris |
| Icon List | Features con ✓, 15px |
| Button | `Empezar ahora`, fondo `#3a4655`, blanco, ancho 100% |

### Card Add-on — Setup $199
| Widget | Config |
|--------|--------|
| Heading | `$199`, font 40px, color `#3a4655` |
| Text Editor | `Pago único · Setup profesional` |
| Text Editor | Descripción del setup |
| Button | `Contratar setup`, outline `#3a4655` |

> **Tip:** Usar el widget nativo **Price Table** de Elementor Pro para las cards.

---

## SECCIÓN 7 — FAQ

**Estructura:** 1 Section → 1 Column (max-width 800px centrado)

### Fondo
- Background: blanco
- Padding: `80px 20px`

### Widgets
| Widget | Config |
|--------|--------|
| Heading | H2, centrado, `#3a4655` → `Preguntas frecuentes` |
| Accordion | Elementor widget `Accordion` — 10 ítems (ver copy-landing.md §7) |

### Config del Accordion
- Title color: `#3a4655`
- Title font: 17px, semi-bold
- Content font: 15px, line-height 1.8
- Active color: `#93abc2`
- Border: bottom only, `#e8ebee`

---

## SECCIÓN 8 — CTA FINAL

**Estructura:** 1 Section full-width, fondo `#3a4655`, texto centrado

### Fondo
- Background: `#3a4655`
- Padding: `100px 20px`

### Widgets
| Widget | Config |
|--------|--------|
| Heading | H2, blanco, 40px, bold, max-width 700px → headline del CTA |
| Text Editor | Subheadline, blanco al 80%, 17px |
| Button | Primario: `Empezar ahora`, fondo blanco, texto `#3a4655` |
| Button | Secundario: `Hablar con el equipo`, outline blanco, texto blanco |
| Text Editor | Trust indicators en línea, blanco, 13px, uppercase |

---

## SCHEMA MARKUP — Cómo agregarlo

### Opción A — Widget HTML en Elementor (más fácil)
1. En la sección Hero, agregar un widget **HTML** antes del primer Heading
2. Pegar el contenido completo de `schema-landing.html`
3. Guardar y verificar con Google Rich Results Test

### Opción B — functions.php del tema hijo (más limpio)
```php
// Agregar al functions.php del tema hijo
function betterseo_landing_schema() {
    if ( is_page( 'better-seo' ) ) {
        // Pegar aquí el contenido de schema-landing.html
        // entre php echo y ;
    }
}
add_action( 'wp_head', 'betterseo_landing_schema' );
```

---

## SEO de la página (Rank Math / Yoast)

Configurar manualmente en el post editor:

| Campo | Valor |
|-------|-------|
| Title Tag | `BetterSEO — SEO & AI Visibility Plugin for Wineries \| Gorilion` |
| Meta Description | `BetterSEO automatically generates Open Graph tags, product schema, and Google Shopping feeds for Commerce7 and eCellar wineries. $30/month. AEO & GEO ready.` |
| Focus Keyword | `Commerce7 SEO plugin` (principal) |
| Secondary Keywords | `eCellar SEO, winery product feed, Open Graph wine, winery Google Shopping` |
| OG Image | Screenshot de Open Graph before/after (1200x630px) |
| Canonical | `https://www.gorilion.com/better-seo/` |

---

## Checklist final antes de publicar

- [ ] Schema validado en https://search.google.com/test/rich-results
- [ ] Open Graph validado en https://developers.facebook.com/tools/debug/
- [ ] Mobile responsive revisado en todos los breakpoints de Elementor
- [ ] Velocidad de carga < 3s (comprimir imágenes de screenshots)
- [ ] Todos los links de CTA apuntan correctamente (formulario o checkout)
- [ ] FAQ accordion funciona en mobile
- [ ] Formulario de contacto conectado a CRM o email

---

*Próximo paso → Template de Elementor para páginas de producto c7_product (Dynamic Tags)*
