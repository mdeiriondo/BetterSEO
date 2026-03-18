import {
  Accordion,
  AccordionContent,
  AccordionItem,
  AccordionTrigger,
} from "@/components/ui/accordion";

// ─── Color tokens ────────────────────────────────────────────────
const C = {
  navy: "#3a4655",
  blue: "#93abc2",
  gray: "#f4f6f8",
  white: "#ffffff",
};

// ─── NAV ─────────────────────────────────────────────────────────
function Nav() {
  return (
    <nav
      style={{ background: C.white, borderBottom: "1px solid #e8ecf0" }}
      className="sticky top-0 z-50"
    >
      <div className="max-w-6xl mx-auto px-6 h-16 flex items-center justify-between">
        <div className="flex items-center gap-2">
          <span className="text-2xl">🦍</span>
          <div>
            <span style={{ color: C.navy }} className="font-bold text-base tracking-tight">
              BetterSEO
            </span>
            <span style={{ color: C.blue }} className="text-xs ml-1 uppercase tracking-widest font-medium">
              by Gorilion
            </span>
          </div>
        </div>
        <div className="hidden md:flex items-center gap-8">
          {["Features", "How It Works", "Pricing", "FAQ"].map((item) => (
            <a
              key={item}
              href="#"
              style={{ color: C.navy }}
              className="text-sm font-medium hover:opacity-60 transition-opacity"
            >
              {item}
            </a>
          ))}
        </div>
        <button
          style={{ background: C.navy, color: C.white }}
          className="text-sm font-semibold px-5 py-2 rounded-md hover:opacity-90 transition-opacity"
        >
          Get Started
        </button>
      </div>
    </nav>
  );
}

// ─── BEFORE / AFTER VISUAL ───────────────────────────────────────
function BeforeAfterVisual() {
  return (
    <div className="flex gap-3 items-start w-full">
      {/* BEFORE */}
      <div className="flex-1">
        <p className="text-xs uppercase tracking-widest mb-2 text-center font-semibold" style={{ color: "#aab5bf" }}>
          Before
        </p>
        <div className="rounded-xl border border-gray-200 bg-white shadow-sm overflow-hidden">
          <div className="p-3 border-b border-gray-100 flex items-center gap-2">
            <div className="w-7 h-7 rounded-full bg-gray-200" />
            <div className="flex-1">
              <div className="h-2 bg-gray-200 rounded w-20 mb-1" />
              <div className="h-1.5 bg-gray-100 rounded w-14" />
            </div>
          </div>
          <div className="p-4 bg-gray-50">
            <p className="text-xs text-gray-400 break-all leading-relaxed">
              Check out this wine: https://jordanwinery.com/product/chardonnay-2023
            </p>
            <div className="mt-3 text-xl text-center">😐</div>
          </div>
        </div>
        <p className="text-xs text-center mt-2 text-gray-400 font-medium">Plain link</p>
      </div>

      {/* AFTER */}
      <div className="flex-1">
        <p className="text-xs uppercase tracking-widest mb-2 text-center font-semibold" style={{ color: C.navy }}>
          After
        </p>
        <div className="rounded-xl border border-gray-200 bg-white shadow-lg overflow-hidden">
          <div className="p-3 border-b border-gray-100 flex items-center gap-2">
            <div className="w-7 h-7 rounded-full bg-gray-200" />
            <div className="flex-1">
              <div className="h-2 bg-gray-200 rounded w-20 mb-1" />
              <div className="h-1.5 bg-gray-100 rounded w-14" />
            </div>
          </div>
          <div
            className="h-24 flex items-center justify-center relative overflow-hidden"
            style={{ background: "linear-gradient(135deg, #1a252f 0%, #3a4655 60%, #2c3e50 100%)" }}
          >
            <span className="text-4xl">🍾</span>
            <div
              className="absolute top-2 left-2 text-xs font-bold uppercase tracking-wider px-2 py-0.5 rounded"
              style={{ background: C.blue, color: C.white }}
            >
              New Arrival
            </div>
          </div>
          <div className="p-3">
            <p className="font-bold text-xs uppercase tracking-wide leading-tight" style={{ color: C.navy }}>
              2023 Jordan Russian River Chardonnay
            </p>
            <p className="text-xs text-gray-500 mt-1 leading-relaxed">
              A beautifully balanced wine — finesse and complexity.
            </p>
            <div className="mt-2 flex items-center justify-between">
              <span className="text-xs font-bold" style={{ color: C.navy }}>$42.00</span>
              <button
                style={{ background: C.navy, color: C.white }}
                className="text-xs font-semibold px-2.5 py-1 rounded"
              >
                Shop Now
              </button>
            </div>
          </div>
        </div>
        <p className="text-xs text-center mt-2 font-semibold" style={{ color: C.navy }}>
          Rich preview
        </p>
      </div>
    </div>
  );
}

// ─── HERO ────────────────────────────────────────────────────────
function Hero() {
  return (
    <section style={{ background: C.white }} className="pt-20 pb-24 px-6">
      <div className="max-w-6xl mx-auto grid md:grid-cols-5 gap-16 items-center">
        <div className="md:col-span-3">
          <p className="text-xs uppercase tracking-[0.2em] font-bold mb-5" style={{ color: C.blue }}>
            SEO + AEO + GEO for Wineries
          </p>
          <h1 className="text-5xl font-bold leading-[1.1] tracking-tight mb-6" style={{ color: C.navy }}>
            Your wine is out there.
            <br />
            <span style={{ color: C.blue }}>Google and AI engines</span>
            <br />
            just can't find it yet.
          </h1>
          <p className="text-lg leading-relaxed mb-8" style={{ color: "#5a6a7a" }}>
            BetterSEO connects your Commerce7 or eCellar catalog directly to the search
            engines and AI tools that recommend wines today — Google, SearchGPT,
            Perplexity, and Google AI Overviews.
          </p>
          <div className="flex flex-wrap gap-3 mb-8">
            <button
              style={{ background: C.navy, color: C.white }}
              className="font-semibold px-7 py-3 rounded-md hover:opacity-90 transition-opacity text-sm"
            >
              Get Started — $30/mo
            </button>
            <button
              style={{ border: `2px solid ${C.navy}`, color: C.navy }}
              className="font-semibold px-7 py-3 rounded-md hover:bg-gray-50 transition-colors text-sm bg-transparent"
            >
              See How It Works ↓
            </button>
          </div>
          <div className="flex flex-wrap gap-x-6 gap-y-2">
            {[
              "Works with Commerce7 & eCellar",
              "Compatible with Rank Math & Yoast",
              "Professional setup available",
              "No long-term contract",
            ].map((item) => (
              <div key={item} className="flex items-center gap-2">
                <span style={{ color: C.blue }} className="font-bold text-sm">✓</span>
                <span className="text-sm" style={{ color: "#5a6a7a" }}>{item}</span>
              </div>
            ))}
          </div>
        </div>
        <div className="md:col-span-2">
          <BeforeAfterVisual />
        </div>
      </div>
    </section>
  );
}

// ─── PAIN POINT ──────────────────────────────────────────────────
function PainPoint() {
  return (
    <section style={{ background: C.gray }} className="py-24 px-6">
      <div className="max-w-3xl mx-auto text-center">
        <h2 className="text-4xl font-bold mb-8 tracking-tight" style={{ color: C.navy }}>
          Search changed.
          <br />
          Wine catalogs didn't.
        </h2>
        <div className="text-left space-y-5 text-base leading-relaxed" style={{ color: "#4a5a6a" }}>
          <p>
            When someone asks ChatGPT <em>"what chardonnay should I buy in Sonoma County?"</em> or
            searches Google for <em>"best Russian River Pinot Noir,"</em> the results don't come
            from magic — they come from structured data, proper metadata, and correctly configured
            Open Graph tags.
          </p>
          <p>
            The problem is that <strong style={{ color: C.navy }}>Commerce7 and eCellar don't
            generate that markup automatically.</strong> Your product pages reach Google without
            their own title tag, no Open Graph image, no price schema, and no product sitemap.
            That's traffic you're losing every single day.
          </p>
          <p>
            BetterSEO fixes exactly that — automatically, without your team touching a line of code.
          </p>
        </div>
      </div>
    </section>
  );
}

// ─── HOW IT WORKS ────────────────────────────────────────────────
function HowItWorks() {
  const steps = [
    {
      num: "01",
      title: "Install the plugin",
      desc: "Add it to your WordPress site like any standard plugin. Five-minute setup in the admin panel — no developer needed.",
    },
    {
      num: "02",
      title: "Connect your platform",
      desc: "Enter your Commerce7 Tenant ID or eCellar API key. BetterSEO syncs your entire wine catalog automatically.",
    },
    {
      num: "03",
      title: "Your products, visible",
      desc: "Every product gets its own SEO title, Open Graph tags, price schema, and canonical URL. Google and AI engines can index them properly.",
    },
  ];

  return (
    <section style={{ background: C.white }} className="py-24 px-6">
      <div className="max-w-6xl mx-auto">
        <h2 className="text-4xl font-bold text-center mb-16 tracking-tight" style={{ color: C.navy }}>
          Three steps. Zero code.
        </h2>
        <div className="grid md:grid-cols-3 gap-10">
          {steps.map((s) => (
            <div key={s.num}>
              <p className="text-7xl font-black mb-4 leading-none" style={{ color: C.blue, opacity: 0.35 }}>
                {s.num}
              </p>
              <h3 className="text-xl font-bold mb-3" style={{ color: C.navy }}>{s.title}</h3>
              <p className="text-base leading-relaxed" style={{ color: "#5a6a7a" }}>{s.desc}</p>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
}

// ─── FEATURE MOCKUPS ─────────────────────────────────────────────
function OpenGraphMockup() {
  return (
    <div className="space-y-4">
      <div className="flex flex-col items-start gap-1.5">
        <div className="rounded-2xl rounded-tl-sm p-3 max-w-xs text-sm" style={{ background: "#e9e9eb", color: "#1c1c1e" }}>
          Hey look at this: https://jordanwinery.com/product/jordan-chardonnay-2023...
        </div>
        <p className="text-xs text-gray-400 ml-1">Before · plain link</p>
      </div>
      <div className="flex flex-col items-start gap-1.5 mt-2">
        <div className="rounded-2xl rounded-tl-sm overflow-hidden max-w-xs shadow-md border border-gray-100">
          <div className="h-28 flex items-center justify-center relative" style={{ background: "linear-gradient(135deg, #1a252f, #3a4655)" }}>
            <span className="text-5xl">🍾</span>
          </div>
          <div className="p-3 bg-white">
            <p className="font-semibold text-xs" style={{ color: C.navy }}>2023 Jordan Cabernet Sauvignon | Jordan Vineyard & Winery</p>
            <p className="text-xs text-gray-400 mt-0.5">jordanwinery.com</p>
          </div>
        </div>
        <p className="text-xs font-semibold ml-1" style={{ color: C.navy }}>After · rich snippet</p>
      </div>
    </div>
  );
}

function GoogleShoppingMockup() {
  const products = [
    { name: "Jordan Cab Sauv 2021", price: "$89.99", badge: "10% OFF", badgeColor: "#e74c3c" },
    { name: "Jordan Chardonnay 2023", price: "$42.00", badge: null, badgeColor: "" },
    { name: "Crown Point Syrah 2020", price: "$149.99", badge: "NEW", badgeColor: C.blue },
    { name: "Crown Point Cab 2019", price: "$179.99", badge: null, badgeColor: "" },
  ];
  return (
    <div className="rounded-xl border border-gray-200 overflow-hidden shadow-lg bg-white">
      <div style={{ background: "#f1f3f4" }} className="px-4 py-2.5 flex items-center gap-2 border-b border-gray-200">
        <div className="flex gap-1.5">
          <div className="w-3 h-3 rounded-full bg-red-400" />
          <div className="w-3 h-3 rounded-full bg-yellow-400" />
          <div className="w-3 h-3 rounded-full bg-green-400" />
        </div>
        <div className="flex-1 bg-white rounded-full px-3 py-1 text-xs text-gray-500 border border-gray-200">
          🛒 Google Shopping · crown point cabernet sauvignon
        </div>
      </div>
      <div className="p-4">
        <div className="grid grid-cols-2 gap-2.5">
          {products.map((p) => (
            <div key={p.name} className="rounded-lg border border-gray-100 overflow-hidden hover:shadow-md transition-shadow">
              <div className="h-20 flex items-center justify-center relative" style={{ background: "linear-gradient(135deg, #1a252f, #2c3e50)" }}>
                <span className="text-3xl">🍷</span>
                {p.badge && (
                  <span className="absolute top-1 right-1 text-xs font-bold px-1.5 py-0.5 rounded" style={{ background: p.badgeColor, color: "#fff" }}>
                    {p.badge}
                  </span>
                )}
              </div>
              <div className="p-2">
                <p className="text-xs font-semibold leading-tight" style={{ color: C.navy }}>{p.name}</p>
                <p className="text-xs font-bold mt-1" style={{ color: "#2d7d46" }}>{p.price}</p>
              </div>
            </div>
          ))}
        </div>
      </div>
    </div>
  );
}

function SerpMockup() {
  return (
    <div className="rounded-xl border border-gray-200 overflow-hidden shadow-md bg-white">
      <div style={{ background: "#f1f3f4" }} className="px-4 py-2.5 flex items-center gap-2 border-b border-gray-200">
        <div className="flex gap-1.5">
          <div className="w-3 h-3 rounded-full bg-red-400" />
          <div className="w-3 h-3 rounded-full bg-yellow-400" />
          <div className="w-3 h-3 rounded-full bg-green-400" />
        </div>
        <div className="flex-1 bg-white rounded-full px-3 py-1 text-xs text-gray-500 border border-gray-200">
          🔍  best Sonoma County chardonnay 2024
        </div>
      </div>
      <div className="p-5">
        <p className="text-xs font-bold uppercase tracking-widest mb-3" style={{ color: C.blue }}>
          Enhanced listing with Open Graph
        </p>
        <div className="flex gap-4 items-start border border-gray-100 rounded-lg p-4">
          <div className="flex-1">
            <div className="flex items-center gap-2 mb-1">
              <div className="w-5 h-5 rounded-full bg-gray-200 flex items-center justify-center text-xs font-bold text-gray-500">J</div>
              <div>
                <p className="text-xs text-gray-500">Jordan Winery</p>
                <p className="text-xs text-gray-400">https://www.jordanwinery.com › Shop Jordan</p>
              </div>
            </div>
            <p className="text-sm font-semibold" style={{ color: "#1a0dab" }}>Buy Russian River Valley Chardonnay</p>
            <p className="text-xs leading-relaxed mt-1 text-gray-600">
              This balanced, elegant Chardonnay can be cellared for 5–8 years. Select library vintages available to buy online.
            </p>
            <p className="text-xs font-bold mt-1" style={{ color: "#2d7d46" }}>US$42.00</p>
          </div>
          <div className="w-16 h-16 rounded-lg flex-shrink-0 flex items-center justify-center" style={{ background: "linear-gradient(135deg, #1a252f, #3a4655)" }}>
            <span className="text-2xl">🍾</span>
          </div>
        </div>
        <div className="flex flex-wrap gap-1.5 mt-3">
          {["JSON-LD", "Schema.org/Product", "Canonical URL", "Sitemap"].map((tag) => (
            <span key={tag} className="text-xs px-2 py-0.5 rounded-full font-medium" style={{ background: "#f0f4f8", color: C.navy }}>
              {tag}
            </span>
          ))}
        </div>
      </div>
    </div>
  );
}

function AIMockup() {
  const engines = [
    { name: "SearchGPT", icon: "⚡" },
    { name: "Perplexity", icon: "🔮" },
    { name: "Google AI Overviews", icon: "🌐" },
    { name: "Claude", icon: "✦" },
  ];
  return (
    <div className="space-y-3">
      <div className="rounded-xl p-4 border" style={{ background: "rgba(255,255,255,0.06)", borderColor: "rgba(255,255,255,0.12)" }}>
        <p className="text-sm font-semibold mb-2" style={{ color: C.blue }}>
          🔍 "Best Napa Cabernet to gift this holiday?"
        </p>
        <p className="text-sm leading-relaxed" style={{ color: "rgba(255,255,255,0.72)" }}>
          Based on current vintages and ratings, the{" "}
          <strong style={{ color: "#fff" }}>2021 Jordan Cabernet Sauvignon</strong> from Alexander Valley is widely regarded as one of the finest — elegant tannins, black fruit, excellent cellaring potential at $89/bottle...
        </p>
      </div>
      <div className="grid grid-cols-2 gap-2">
        {engines.map((e) => (
          <div key={e.name} className="rounded-lg p-3 flex items-center gap-2 border" style={{ background: "rgba(255,255,255,0.04)", borderColor: "rgba(255,255,255,0.1)" }}>
            <span className="text-base">{e.icon}</span>
            <span className="text-xs font-medium" style={{ color: "rgba(255,255,255,0.75)" }}>{e.name}</span>
          </div>
        ))}
      </div>
    </div>
  );
}

// ─── FEATURES ────────────────────────────────────────────────────
function Features() {
  const features = [
    {
      bg: C.gray, dark: false, imgRight: false,
      label: "Open Graph",
      title: "Rich previews across social, messaging & chat",
      desc: "When someone shares your wine on Instagram, WhatsApp, or LinkedIn, instead of a bare link they see the product image, name, and description. BetterSEO generates the correct og:title, og:image, og:description, og:type, and Twitter Card tags for every product — automatically.",
      tags: ["og:title", "og:image", "og:description", "Twitter Card"],
      visual: <OpenGraphMockup />,
    },
    {
      bg: C.white, dark: false, imgRight: true,
      label: "Product Feeds",
      title: "Your wines in Google Shopping and beyond",
      desc: "BetterSEO generates product feeds compatible with Google Shopping, Vivino, and Facebook Ads. Your inventory appears in Shopping results — with image, price, and availability updated automatically whenever your Commerce7 or eCellar catalog changes.",
      tags: ["Google Shopping", "Vivino", "Facebook Ads", "Auto-sync"],
      visual: <GoogleShoppingMockup />,
    },
    {
      bg: C.gray, dark: false, imgRight: false,
      label: "Schema + Metadata",
      title: "Signals search engines actually understand",
      desc: "Every product page automatically generates its own title tag, meta description, product JSON-LD with price and brand, canonical URL, and product sitemap — everything Rank Math and Yoast can't do alone for external catalogs like Commerce7.",
      tags: ["JSON-LD", "Schema.org/Product", "Canonical URL", "Sitemap", "Rank Math", "Yoast"],
      visual: <SerpMockup />,
    },
    {
      bg: C.navy, dark: true, imgRight: true,
      label: "AEO & GEO",
      title: "Show up in AI answers, not just Google results",
      desc: 'Google AI Overviews, SearchGPT, Perplexity, and Claude answer questions like “what\'s the best Napa Cabernet?” using pages with properly structured data. Without product schema, your wine simply doesn\'t exist to them. BetterSEO structures your pages exactly as AI crawlers expect.',
      tags: ["Google AI Overviews", "SearchGPT", "Perplexity", "Entity SEO"],
      visual: <AIMockup />,
    },
  ];

  return (
    <section id="features">
      {features.map((f) => (
        <div key={f.label} style={{ background: f.bg }} className="py-24 px-6">
          <div className="max-w-6xl mx-auto grid md:grid-cols-2 gap-16 items-center">
            <div className={f.imgRight ? "order-1" : "order-1 md:order-2"}>
              <p className="text-xs uppercase tracking-[0.2em] font-bold mb-4" style={{ color: C.blue }}>
                {f.label}
              </p>
              <h3 className="text-3xl font-bold mb-5 leading-tight tracking-tight" style={{ color: f.dark ? C.white : C.navy }}>
                {f.title}
              </h3>
              <p className="text-base leading-relaxed mb-6" style={{ color: f.dark ? "rgba(255,255,255,0.7)" : "#5a6a7a" }}>
                {f.desc}
              </p>
              <div className="flex flex-wrap gap-2">
                {f.tags.map((tag) => (
                  <span
                    key={tag}
                    className="text-xs font-semibold px-3 py-1 rounded-full"
                    style={f.dark
                      ? { background: "rgba(255,255,255,0.1)", color: C.white }
                      : { background: C.navy, color: C.white }}
                  >
                    {tag}
                  </span>
                ))}
              </div>
            </div>
            <div className={f.imgRight ? "order-2" : "order-2 md:order-1"}>
              {f.visual}
            </div>
          </div>
        </div>
      ))}
    </section>
  );
}

// ─── SOCIAL PROOF ────────────────────────────────────────────────
function SocialProof() {
  const wineries = ["Jordan Winery", "Crown Point", "Wilson Creek", "Hahn Family", "Napa Valley Co.", "Sonoma Estate"];
  return (
    <section style={{ background: C.white }} className="py-24 px-6">
      <div className="max-w-5xl mx-auto">
        <p className="text-xs uppercase tracking-[0.2em] font-bold text-center mb-10" style={{ color: C.blue }}>
          Wineries already showing up where it counts
        </p>
        <div className="grid grid-cols-3 md:grid-cols-6 gap-3 mb-16">
          {wineries.map((w) => (
            <div key={w} className="rounded-lg py-3 px-2 flex items-center justify-center border text-center" style={{ borderColor: "#e8ecf0" }}>
              <span className="text-xs font-semibold text-gray-400 leading-tight">{w}</span>
            </div>
          ))}
        </div>
        <div className="rounded-2xl p-8 max-w-2xl mx-auto" style={{ background: C.gray, borderLeft: `5px solid ${C.navy}` }}>
          <p className="text-lg leading-relaxed italic mb-6" style={{ color: C.navy }}>
            "BetterSEO resolved in one week what had been broken for months. Our products
            now appear in Google Shopping and our organic traffic grew 34% in three months —
            without changing our Commerce7 setup at all."
          </p>
          <div className="flex items-center gap-3">
            <div className="w-12 h-12 rounded-full flex items-center justify-center text-xl font-bold" style={{ background: C.navy, color: C.white }}>
              S
            </div>
            <div>
              <p className="font-bold text-sm" style={{ color: C.navy }}>Sarah M.</p>
              <p className="text-xs" style={{ color: C.blue }}>Marketing Director — Jordan Winery</p>
            </div>
          </div>
        </div>
      </div>
    </section>
  );
}

// ─── PRICING ─────────────────────────────────────────────────────
function Pricing() {
  const mainFeatures = [
    "Open Graph for all product pages",
    "Schema.org Product JSON-LD",
    "Google Shopping product feed",
    "Vivino & Facebook Ads feeds",
    "Product sitemap generation",
    "Canonical URL per product",
    "Commerce7 & eCellar sync",
    "Rank Math & Yoast compatible",
    "Automatic catalog updates",
  ];
  return (
    <section style={{ background: C.gray }} className="py-24 px-6" id="pricing">
      <div className="max-w-5xl mx-auto">
        <h2 className="text-4xl font-bold text-center mb-4 tracking-tight" style={{ color: C.navy }}>
          Straightforward pricing.
        </h2>
        <p className="text-center text-base mb-14" style={{ color: "#5a6a7a" }}>
          No surprises. No per-product fees. Just your wines, visible.
        </p>
        <div className="grid md:grid-cols-2 gap-6 items-start">
          {/* Main plan */}
          <div className="rounded-2xl overflow-hidden shadow-xl border-2" style={{ borderColor: C.navy, background: C.white }}>
            <div style={{ background: C.navy }} className="p-6">
              <p className="text-xs uppercase tracking-widest font-bold mb-2" style={{ color: C.blue }}>BetterSEO Standard</p>
              <div className="flex items-end gap-2">
                <span className="text-5xl font-black text-white">$30</span>
                <span className="text-white opacity-60 mb-1">/month</span>
              </div>
              <p className="text-xs mt-1 opacity-50 text-white">Monthly billing · Cancel anytime</p>
            </div>
            <div className="p-6">
              <ul className="space-y-3 mb-8">
                {mainFeatures.map((f) => (
                  <li key={f} className="flex items-start gap-3 text-sm" style={{ color: C.navy }}>
                    <span style={{ color: C.blue }} className="font-bold mt-0.5 flex-shrink-0">✓</span>
                    {f}
                  </li>
                ))}
              </ul>
              <button style={{ background: C.navy, color: C.white }} className="w-full py-3 rounded-lg font-bold text-sm hover:opacity-90 transition-opacity">
                Get Started Now
              </button>
            </div>
          </div>
          {/* Setup add-on */}
          <div className="rounded-2xl overflow-hidden border" style={{ borderColor: "#d8e0e8", background: C.white }}>
            <div style={{ background: C.gray }} className="p-6">
              <p className="text-xs uppercase tracking-widest font-bold mb-2" style={{ color: C.blue }}>Professional Setup</p>
              <div className="flex items-end gap-2">
                <span className="text-5xl font-black" style={{ color: C.navy }}>$199</span>
                <span className="mb-1" style={{ color: "#5a6a7a" }}>one-time</span>
              </div>
              <p className="text-xs mt-1 text-gray-400">Done by the Gorilion team</p>
            </div>
            <div className="p-6">
              <p className="text-sm leading-relaxed mb-5" style={{ color: "#5a6a7a" }}>
                Installation, configuration, and verification by the Gorilion team. Includes a full review of existing metadata, feed activation, Commerce7 or eCellar connection, and a 30-day follow-up check.
              </p>
              <ul className="space-y-2 mb-8">
                {["Plugin install & configuration", "Commerce7 / eCellar connection", "Metadata audit & cleanup", "Feed activation & testing", "30-day follow-up check"].map((f) => (
                  <li key={f} className="flex items-start gap-3 text-sm" style={{ color: C.navy }}>
                    <span style={{ color: C.blue }} className="font-bold flex-shrink-0">✓</span>
                    {f}
                  </li>
                ))}
              </ul>
              <button style={{ border: `2px solid ${C.navy}`, color: C.navy }} className="w-full py-3 rounded-lg font-bold text-sm hover:bg-gray-50 transition-colors bg-transparent">
                Add Professional Setup
              </button>
              <p className="text-xs text-center mt-3 text-gray-400">Available as add-on with any plan</p>
            </div>
          </div>
        </div>
      </div>
    </section>
  );
}

// ─── FAQ ─────────────────────────────────────────────────────────
function FAQ() {
  const faqs = [
    { q: "Does BetterSEO work with Commerce7?", a: "Yes. BetterSEO is designed specifically for Commerce7. It connects via your Tenant ID, automatically syncs your entire product catalog, and generates the corresponding SEO metadata — no manual configuration required per product." },
    { q: "Does BetterSEO work with eCellar?", a: "Yes. BetterSEO supports eCellar using your API key. The sync and metadata generation process is identical to Commerce7." },
    { q: "Do I need coding knowledge to install it?", a: "No. BetterSEO is a standard WordPress plugin. Install it from the WordPress admin dashboard, enter your Commerce7 or eCellar credentials, and the plugin handles everything automatically. If you prefer, Gorilion's team handles the full setup for a one-time $199 fee." },
    { q: "Is it compatible with Rank Math and Yoast SEO?", a: "Yes. BetterSEO detects which plugin you have active and works alongside it, disabling only the modules that would conflict with product pages — preventing duplicate metadata." },
    { q: "How does BetterSEO help wineries appear in ChatGPT and Perplexity?", a: 'AI engines like Google AI Overviews, ChatGPT (SearchGPT), Perplexity, and Claude use pages with properly structured data to answer questions like “what is the best Pinot Noir in Sonoma.” BetterSEO generates Schema.org Product markup with complete product attributes — varietal, vintage, region, price — exactly what AI crawlers need to include your wines in their answers.' },
    { q: "Can I cancel at any time?", a: "Yes. No long-term contracts. Cancel your subscription at any time from your client dashboard." },
  ];

  return (
    <section style={{ background: C.white }} className="py-24 px-6" id="faq">
      <div className="max-w-3xl mx-auto">
        <h2 className="text-4xl font-bold text-center mb-12 tracking-tight" style={{ color: C.navy }}>
          Frequently asked questions
        </h2>
        <Accordion type="multiple" defaultValue={faqs.map((_, i) => `item-${i}`)}>
          {faqs.map((f, i) => (
            <AccordionItem key={i} value={`item-${i}`} style={{ borderColor: "#e8ecf0" }}>
              <AccordionTrigger className="text-left font-semibold text-base hover:no-underline" style={{ color: C.navy }}>
                {f.q}
              </AccordionTrigger>
              <AccordionContent className="text-base leading-relaxed" style={{ color: "#5a6a7a" }}>
                {f.a}
              </AccordionContent>
            </AccordionItem>
          ))}
        </Accordion>
      </div>
    </section>
  );
}

// ─── CTA FINAL ───────────────────────────────────────────────────
function CtaFinal() {
  return (
    <section style={{ background: C.navy }} className="py-28 px-6 text-center">
      <div className="max-w-3xl mx-auto">
        <p className="text-xs uppercase tracking-[0.2em] font-bold mb-6" style={{ color: C.blue }}>
          Ready to get found
        </p>
        <h2 className="text-4xl md:text-5xl font-bold text-white mb-6 leading-tight tracking-tight">
          Your catalog deserves to show up
          <br />
          where buyers are looking.
        </h2>
        <p className="text-lg mb-10" style={{ color: "rgba(255,255,255,0.68)" }}>
          Start with BetterSEO today. $30 a month, up and running in under 24 hours, cancel anytime.
        </p>
        <div className="flex flex-wrap justify-center gap-4 mb-8">
          <button style={{ background: C.white, color: C.navy }} className="font-bold px-8 py-4 rounded-lg hover:opacity-90 transition-opacity text-sm">
            Get Started Now
          </button>
          <button style={{ border: "2px solid rgba(255,255,255,0.35)", color: C.white }} className="font-semibold px-8 py-4 rounded-lg hover:bg-white/10 transition-colors text-sm bg-transparent">
            Talk to the Team
          </button>
        </div>
        <p className="text-xs" style={{ color: "rgba(255,255,255,0.38)" }}>
          No contract · Setup in 24h · Support included · Commerce7 & eCellar
        </p>
      </div>
    </section>
  );
}

// ─── FOOTER ──────────────────────────────────────────────────────
function Footer() {
  return (
    <footer style={{ background: "#272f3a", color: "rgba(255,255,255,0.5)" }} className="py-14 px-6">
      <div className="max-w-6xl mx-auto grid md:grid-cols-4 gap-10">
        <div className="md:col-span-2">
          <div className="flex items-center gap-2 mb-3">
            <span className="text-xl">🦍</span>
            <span className="font-bold text-white text-sm tracking-tight">
              BetterSEO <span style={{ color: C.blue }}>by Gorilion</span>
            </span>
          </div>
          <p className="text-sm leading-relaxed max-w-xs">
            SEO, Open Graph, product feeds, and AI engine optimization for winery e-commerce. Built for Commerce7 and eCellar.
          </p>
        </div>
        <div>
          <p className="text-xs uppercase tracking-widest font-bold mb-4 text-white">Product</p>
          <ul className="space-y-2">
            {["Features", "Pricing", "FAQ", "Changelog"].map((item) => (
              <li key={item}><a href="#" className="text-sm hover:text-white transition-colors">{item}</a></li>
            ))}
          </ul>
        </div>
        <div>
          <p className="text-xs uppercase tracking-widest font-bold mb-4 text-white">Gorilion</p>
          <ul className="space-y-2">
            {["About", "BetterSOMM", "BetterLABEL", "Contact"].map((item) => (
              <li key={item}><a href="#" className="text-sm hover:text-white transition-colors">{item}</a></li>
            ))}
          </ul>
        </div>
      </div>
      <div className="max-w-6xl mx-auto mt-12 pt-6 flex flex-wrap justify-between gap-4 items-center" style={{ borderTop: "1px solid rgba(255,255,255,0.08)" }}>
        <p className="text-xs">© 2026 Gorilion. All rights reserved.</p>
        <div className="flex gap-6">
          {["Privacy Policy", "Terms of Service"].map((item) => (
            <a key={item} href="#" className="text-xs hover:text-white transition-colors">{item}</a>
          ))}
        </div>
      </div>
    </footer>
  );
}

// ─── APP ─────────────────────────────────────────────────────────
export default function App() {
  return (
    <div className="font-sans antialiased">
      <Nav />
      <Hero />
      <PainPoint />
      <HowItWorks />
      <Features />
      <SocialProof />
      <Pricing />
      <FAQ />
      <CtaFinal />
      <Footer />
    </div>
  );
}
