#!/usr/bin/env python3
"""Verify hero launch-state content and capture screenshots."""

import sys
from datetime import date
from pathlib import Path

from playwright.sync_api import sync_playwright

BASE_URL = 'https://www.simpledentallv.com'
REPO_ROOT = Path(__file__).resolve().parent
SCREENSHOT_DIR = REPO_ROOT / 'playwright-screenshots'
OPENING_DATE = date(2026, 4, 6)

SCREENSHOT_DIR.mkdir(exist_ok=True)

COUNTDOWN_SELECTORS = [
    ".countdown-wrapper",
    ".countdown-timer",
    ".countdown-unit",
    ".countdown-days",
    ".countdown-hours",
    ".countdown-mins",
    ".countdown-secs",
]

PRE_OPEN_PATTERNS = [
    'opening april 6, 2026',
    'apertura el 6 de abril de 2026',
    '2026年4月6日开业',
    '2026年4月6日開幕',
]

OPEN_PATTERNS = [
    'now open',
    'ya estamos abiertos',
    '现已开业',
    '現已開幕',
]


def expected_hero_patterns() -> list[str]:
    return OPEN_PATTERNS if date.today() >= OPENING_DATE else PRE_OPEN_PATTERNS


def expected_hero_label() -> str:
    return 'Now Open' if date.today() >= OPENING_DATE else 'Opening April 6, 2026'


def check_page(page, url: str, label: str) -> dict:
    print(f"\n{'='*60}")
    print(f"CHECKING: {label}")
    print(f"URL: {url}")
    print("=" * 60)

    page.goto(url, wait_until="networkidle", timeout=30000)
    page.wait_for_timeout(2000)

    # --- [1] Check countdown elements are GONE ---
    print("\n[1] Countdown Timer Elements (should ALL be absent):")
    countdown_found = False
    for sel in COUNTDOWN_SELECTORS:
        count = page.locator(sel).count()
        if count == 0:
            status = "ABSENT (OK)"
        else:
            status = f"PRESENT ({count} element(s)) -- FAIL"
            countdown_found = True
        print(f"    {sel}: {status}")

    if not countdown_found:
        print("    => ALL countdown elements are GONE. PASS")
    else:
        print("    => Some countdown elements still present. FAIL")

    # --- [2] Check hero launch-state label ---
    print(f"\n[2] Hero launch-state label (should include '{expected_hero_label()}'):")

    hero_label_count = page.locator('.opening-soon-label').count()
    print(f'    .opening-soon-label elements found: {hero_label_count}')

    body_text = page.evaluate("() => document.body.innerText").lower()

    hero_label_found = False
    matched_pattern = None
    for pattern in expected_hero_patterns():
        if pattern.lower() in body_text:
            hero_label_found = True
            matched_pattern = pattern
            break

    if hero_label_found:
        print(f"    Expected hero text FOUND (matched: '{matched_pattern}'). PASS")
    elif hero_label_count > 0:
        label_text = ' | '.join(page.locator('.opening-soon-label').all_inner_texts()).strip()
        print(f"    .opening-soon-label element exists but expected text was not matched. FAIL")
        print(f"    Label text found: {label_text}")
    else:
        print('    Expected hero text NOT found. FAIL')
        # Print hero text for debugging
        hero_text = page.evaluate("""() => {
            const hero = document.querySelector('.hero, .hero-section, .hero-content, [class*="hero"]');
            return hero ? hero.innerText.trim().substring(0, 500) : 'No hero element found';
        }""")
        print(f"    Hero section text snippet:\n      {hero_text}")

    # --- [3] Take screenshot of hero section ---
    print("\n[3] Screenshot:")
    safe_label = label.replace("/", "_").replace(" ", "_").replace("(", "").replace(")", "").replace("=", "")
    screenshot_file = SCREENSHOT_DIR / f'{safe_label}.png'

    # Try hero section first
    hero_locator = page.locator(".hero, .hero-section, .hero-content, section.hero").first
    try:
        hero_locator.screenshot(path=str(screenshot_file), timeout=5000)
        print(f"    Hero section screenshot saved: {screenshot_file}")
    except Exception:
        # Fallback to viewport screenshot
        page.screenshot(path=str(screenshot_file), clip={"x": 0, "y": 0, "width": 1280, "height": 800})
        print(f"    Viewport screenshot saved: {screenshot_file}")

    return {
        "label": label,
        "url": url,
        "countdown_gone": not countdown_found,
        "hero_label_present": hero_label_found,
        "hero_label_count": hero_label_count,
        "matched_pattern": matched_pattern,
        "error": None,
    }


def main():
    checks = [
        (f"{BASE_URL}/", "English (default)"),
        (f"{BASE_URL}/?lang=es", "Spanish (lang=es)"),
        (f"{BASE_URL}/?lang=zh-CN", "Simplified Chinese (lang=zh-CN)"),
        (f"{BASE_URL}/?lang=zh-TW", "Traditional Chinese (lang=zh-TW)"),
    ]

    results = []

    with sync_playwright() as p:
        browser = p.chromium.launch(headless=True)
        context = browser.new_context(
            viewport={"width": 1280, "height": 900},
            user_agent="Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 Chrome/120 PlaywrightVerify",
        )

        for url, label in checks:
            page = context.new_page()
            try:
                result = check_page(page, url, label)
                results.append(result)
            except Exception as e:
                print(f"\nERROR on {label}: {e}")
                results.append({"label": label, "url": url, "error": str(e)})
            finally:
                page.close()

        browser.close()

    # Final summary
    print(f"\n\n{'='*60}")
    print("FINAL SUMMARY")
    print("=" * 60)

    all_pass = True
    for r in results:
        if r.get("error"):
            print(f"\n{r['label']}: ERROR - {r['error']}")
            all_pass = False
            continue

        countdown_status = "PASS" if r["countdown_gone"] else "FAIL"
        hero_status = "PASS" if r["hero_label_present"] else "FAIL"

        print(f"\n{r['label']} ({r['url']}):")
        print(f"  Countdown GONE:          {countdown_status}")
        print(f"  Hero status present:     {hero_status}")
        if r["hero_label_count"] > 0:
            print(f"    .opening-soon-label count: {r['hero_label_count']}")
        if r["matched_pattern"]:
            print(f"    Text matched: '{r['matched_pattern']}'")

        if not r["countdown_gone"] or not r["hero_label_present"]:
            all_pass = False

    print(f"\n{'='*60}")
    print(f"OVERALL: {'ALL CHECKS PASSED' if all_pass else 'SOME CHECKS FAILED'}")
    print(f"Screenshots saved to: {SCREENSHOT_DIR}")
    print("=" * 60)

    return 0 if all_pass else 1


if __name__ == "__main__":
    sys.exit(main())
