<?php
/**
 * Treatment Guides & Prices content.
 *
 * Source: patient-education charts supplied by Dr. Chang (crown materials,
 * implant process, cavity stages, gum disease stages, partial and full
 * dentures). Prices live here so the page, price list, and schema agree.
 */

if (!defined('ABSPATH')) {
    exit;
}

function simple_dental_get_treatment_guides_path() {
    return '/treatment-guides/';
}

function simple_dental_get_dental_health_path() {
    return '/cavity-gum-disease-guide/';
}

/**
 * Translate a guide string by stable key, falling back to the English copy.
 */
function simple_dental_guide_t($key, $text) {
    return __t($text, 'key:guides.' . $key);
}

function simple_dental_get_treatment_guides_data() {
    $t = 'simple_dental_guide_t';

    $label_looks = $t('spec.looks', 'Natural look');
    $label_strength = $t('spec.strength', 'Strength');
    $label_durability = $t('spec.durability', 'Long-term durability');
    $label_best_for = $t('spec.best_for', 'Best for');
    $label_material = $t('spec.material', 'Material');
    $label_made = $t('spec.made', 'How it is made');
    $label_time = $t('spec.time', 'Time to make');
    $label_metal = $t('spec.metal', 'Metal');
    $label_add_teeth = $t('spec.add_teeth', 'Add teeth later');
    $label_colors = $t('spec.colors', 'Shade choices');

    $weeks_short = $t('time.2_3_weeks', 'About 2–3 weeks');
    $weeks_long = $t('time.4_6_weeks', 'About 4–6 weeks');

    return array(
        'crowns' => array(
            'id' => 'crowns',
            'nav' => $t('crowns.nav', 'Crowns'),
            'title' => $t('crowns.title', 'Crown materials compared'),
            'intro' => $t('crowns.intro', 'Every crown does the same job. The material changes how it looks, how long it lasts, and what it costs. We help you choose the one that fits your tooth.'),
            'unit' => $t('unit.per_crown', 'per crown'),
            'options' => array(
                array(
                    'name' => $t('crowns.pmma.name', 'PMMA temporary crown'),
                    'sub' => $t('crowns.pmma.sub', 'Temporary crown'),
                    'price' => '$350',
                    'desc' => $t('crowns.pmma.desc', 'PMMA is a durable acrylic resin most often used for temporary crowns.'),
                    'pros' => array(
                        $t('crowns.pmma.pro1', 'Lowest price'),
                        $t('crowns.pmma.pro2', 'Quick to make'),
                        $t('crowns.pmma.pro3', 'Protects the tooth until the final crown is ready'),
                    ),
                    'cons' => array(
                        $t('crowns.pmma.con1', 'Lower strength, wears down more easily'),
                        $t('crowns.pmma.con2', 'May fracture with long-term use'),
                        $t('crowns.pmma.con3', 'Looks less natural than a real tooth'),
                    ),
                    'specs' => array(
                        array($label_looks, 2),
                        array($label_strength, 2),
                        array($label_durability, 1),
                        array($label_best_for, $t('crowns.pmma.best', 'Temporary use, any tooth')),
                        array($label_material, $t('crowns.pmma.material', 'Acrylic resin (PMMA)')),
                    ),
                ),
                array(
                    'name' => $t('crowns.camo.name', 'Camouflage crown'),
                    'sub' => $t('crowns.camo.sub', 'Resin-based ceramic'),
                    'price' => '$550',
                    'desc' => $t('crowns.camo.desc', 'Camouflage is a resin-based ceramic crown that balances appearance and price.'),
                    'pros' => array(
                        $t('crowns.camo.pro1', 'Natural-looking'),
                        $t('crowns.camo.pro2', 'Better looking than PMMA'),
                        $t('crowns.camo.pro3', 'Suits front teeth and premolars'),
                        $t('crowns.camo.pro4', 'Budget-friendly'),
                    ),
                    'cons' => array(
                        $t('crowns.camo.con1', 'Not as strong as zirconia or lithium disilicate'),
                        $t('crowns.camo.con2', 'Less suited to molars, where bite force is higher'),
                        $t('crowns.camo.con3', 'May wear or chip over time'),
                    ),
                    'specs' => array(
                        array($label_looks, 3),
                        array($label_strength, 3),
                        array($label_durability, 3),
                        array($label_best_for, $t('crowns.camo.best', 'Front teeth or premolars with lighter bite force')),
                        array($label_material, $t('crowns.camo.material', 'Resin-based ceramic')),
                    ),
                ),
                array(
                    'name' => $t('crowns.obsidian.name', 'Obsidian all-ceramic crown'),
                    'sub' => $t('crowns.obsidian.sub', 'Lithium disilicate'),
                    'price' => '$899',
                    'desc' => $t('crowns.obsidian.desc', 'Obsidian is a high-strength lithium disilicate ceramic with excellent appearance and no metal.'),
                    'pros' => array(
                        $t('crowns.obsidian.pro1', 'Very natural and attractive'),
                        $t('crowns.obsidian.pro2', 'An excellent choice for front teeth'),
                        $t('crowns.obsidian.pro3', 'Strong enough for most situations'),
                        $t('crowns.obsidian.pro4', 'Biocompatible and metal-free'),
                    ),
                    'cons' => array(
                        $t('crowns.obsidian.con1', 'Not as strong as zirconia; can crack under extreme bite force'),
                        $t('crowns.obsidian.con2', 'Not recommended for a heavy bite or severe grinding'),
                        $t('crowns.obsidian.con3', 'Higher price'),
                    ),
                    'specs' => array(
                        array($label_looks, 4),
                        array($label_strength, 3),
                        array($label_durability, 4),
                        array($label_best_for, $t('crowns.obsidian.best', 'Front teeth, or anywhere appearance matters most')),
                        array($label_material, $t('crowns.obsidian.material', 'Lithium disilicate all-ceramic')),
                    ),
                ),
                array(
                    'name' => $t('crowns.azr.name', 'Aesthetic zirconia crown'),
                    'sub' => $t('crowns.azr.sub', 'High-translucency zirconia'),
                    'price' => '$899',
                    'desc' => $t('crowns.azr.desc', 'High-translucency zirconia combines strength with a natural look, for front or back teeth.'),
                    'pros' => array(
                        $t('crowns.azr.pro1', 'Strong and durable'),
                        $t('crowns.azr.pro2', 'Natural-looking'),
                        $t('crowns.azr.pro3', 'Works for both front and back teeth'),
                        $t('crowns.azr.pro4', 'Biocompatible and metal-free'),
                    ),
                    'cons' => array(
                        $t('crowns.azr.con1', 'Slightly less translucent than lithium disilicate'),
                    ),
                    'specs' => array(
                        array($label_looks, 4),
                        array($label_strength, 4),
                        array($label_durability, 4),
                        array($label_best_for, $t('crowns.azr.best', 'Front or back teeth, balancing looks and strength')),
                        array($label_material, $t('crowns.azr.material', 'High-translucency zirconia')),
                    ),
                ),
                array(
                    'name' => $t('crowns.szr.name', 'Standard zirconia crown'),
                    'sub' => $t('crowns.szr.sub', 'High-strength zirconia'),
                    'price' => '$899',
                    'desc' => $t('crowns.szr.desc', 'Standard zirconia is a very tough ceramic, most often used on back teeth that take heavy bite force.'),
                    'pros' => array(
                        $t('crowns.szr.pro1', 'The strongest and most durable option'),
                        $t('crowns.szr.pro2', 'Ideal for back teeth and molars'),
                        $t('crowns.szr.pro3', 'Biocompatible and metal-free'),
                    ),
                    'cons' => array(
                        $t('crowns.szr.con1', 'More opaque, so it looks less natural'),
                        $t('crowns.szr.con2', 'Not recommended for front teeth when appearance is the priority'),
                    ),
                    'specs' => array(
                        array($label_looks, 3),
                        array($label_strength, 5),
                        array($label_durability, 5),
                        array($label_best_for, $t('crowns.szr.best', 'Back teeth and molars with heavy bite force')),
                        array($label_material, $t('crowns.szr.material', 'High-strength zirconia')),
                    ),
                ),
            ),
        ),

        'implants' => array(
            'id' => 'implants',
            'nav' => $t('implants.nav', 'Implants'),
            'title' => $t('implants.title', 'From extraction to a new tooth'),
            'intro' => $t('implants.intro', 'A step-by-step guide to dental implant treatment: replacing a missing tooth with a strong, natural, long-lasting solution.'),
            'steps' => array(
                array(
                    'title' => $t('implants.s1.title', 'Tooth extraction'),
                    'summary' => $t('implants.s1.summary', 'Remove the damaged tooth that cannot be saved.'),
                    'points' => array(
                        $t('implants.s1.p1', 'Remove the non-restorable tooth.'),
                        $t('implants.s1.p2', 'Clean the area and remove infection.'),
                        $t('implants.s1.p3', 'Preserve as much healthy bone and tissue as possible.'),
                    ),
                ),
                array(
                    'title' => $t('implants.s2.title', 'Bone graft'),
                    'summary' => $t('implants.s2.summary', 'Rebuild the bone to create a strong foundation for the implant.'),
                    'points' => array(
                        $t('implants.s2.p1', 'Bone graft material is placed into the extraction site.'),
                        $t('implants.s2.p2', 'A protective membrane covers it if needed.'),
                        $t('implants.s2.p3', 'Helps maintain bone width and height.'),
                    ),
                ),
                array(
                    'title' => $t('implants.s3.title', 'Healing period'),
                    'summary' => $t('implants.s3.summary', 'Allow time for the bone to heal and become strong.'),
                    'points' => array(
                        $t('implants.s3.p1', 'The bone graft integrates with your natural bone.'),
                        $t('implants.s3.p2', 'Usually 3–6 months, depending on the case.'),
                        $t('implants.s3.p3', 'You may wear a temporary tooth during this time if needed.'),
                    ),
                ),
                array(
                    'title' => $t('implants.s4.title', 'Implant placement'),
                    'summary' => $t('implants.s4.summary', 'Place a titanium implant into the jawbone.'),
                    'points' => array(
                        $t('implants.s4.p1', 'A small surgical procedure places the implant into the healed bone.'),
                        $t('implants.s4.p2', 'A healing cap is attached.'),
                        $t('implants.s4.p3', 'Allow about 3–4 months for the implant to integrate with the bone (osseointegration).'),
                    ),
                ),
                array(
                    'title' => $t('implants.s5.title', 'Abutment placement'),
                    'summary' => $t('implants.s5.summary', 'Connect an abutment to support the final crown.'),
                    'points' => array(
                        $t('implants.s5.p1', 'After the implant has healed, the healing cap is removed.'),
                        $t('implants.s5.p2', 'A custom abutment is attached.'),
                        $t('implants.s5.p3', 'The gum tissue is shaped for a natural appearance (about 2–3 weeks).'),
                    ),
                ),
                array(
                    'title' => $t('implants.s6.title', 'Final crown'),
                    'summary' => $t('implants.s6.summary', 'Place a custom-made crown that looks and functions like a natural tooth.'),
                    'points' => array(
                        $t('implants.s6.p1', 'A digital scan or impression is taken.'),
                        $t('implants.s6.p2', 'A custom crown is made to match your natural teeth.'),
                        $t('implants.s6.p3', 'The crown is attached to the abutment.'),
                    ),
                ),
            ),
            'timeline_title' => $t('implants.timeline.title', 'Typical timeline'),
            'timeline' => array(
                array($t('implants.timeline.r1', 'Extraction and bone graft'), $t('implants.timeline.v1', '0–3 months')),
                array($t('implants.timeline.r2', 'Implant placement and healing'), $t('implants.timeline.v2', '3–6 months')),
                array($t('implants.timeline.r3', 'Abutment and gum shaping'), $t('implants.timeline.v3', '+ 2–3 weeks')),
                array($t('implants.timeline.r4', 'Final crown'), $t('implants.timeline.v4', '+ 1–2 weeks')),
            ),
            'timeline_total_label' => $t('implants.timeline.total_label', 'Total treatment time'),
            'timeline_total' => $t('implants.timeline.total', 'About 6–12 months'),
            'timeline_note' => $t('implants.timeline.note', 'Timing varies with each case.'),
            'benefits_title' => $t('implants.benefits.title', 'Why patients choose implants'),
            'benefits' => array(
                $t('implants.benefits.b1', 'Looks and functions like a natural tooth'),
                $t('implants.benefits.b2', 'Helps preserve bone and facial structure'),
                $t('implants.benefits.b3', 'Restores chewing and confidence'),
                $t('implants.benefits.b4', 'Success rate over 95%'),
                $t('implants.benefits.b5', 'Can last many years with proper care'),
            ),
            'price_note' => $t('implants.price_note', 'Implant fees depend on how many of these steps your case needs. Call us and we will explain your options and cost before any treatment begins.'),
        ),

        'cavities' => array(
            'id' => 'cavities',
            'nav' => $t('cavities.nav', 'Cavities'),
            'title' => $t('cavities.title', 'How a cavity progresses, and how each stage is treated'),
            'intro' => $t('cavities.intro', 'Found early and treated early, more of your healthy tooth is kept.'),
            'scale_start' => $t('cavities.scale_start', 'Easier to treat, keeps your natural tooth'),
            'scale_end' => $t('cavities.scale_end', 'More complex treatment, may need extraction'),
            'signs_label' => $t('stage.signs', 'What you may notice'),
            'treatment_label' => $t('stage.treatment', 'Treatment'),
            'stages' => array(
                array(
                    'name' => $t('cavities.c1.name', 'Early cavity'),
                    'sub' => $t('cavities.c1.sub', 'A very small cavity'),
                    'points' => array(
                        $t('cavities.c1.p1', 'Only in the enamel'),
                        $t('cavities.c1.p2', 'May have no symptoms'),
                        $t('cavities.c1.p3', 'Usually painless'),
                    ),
                    'treatment' => $t('cavities.c1.tx', 'Simple filling'),
                ),
                array(
                    'name' => $t('cavities.c2.name', 'Moderate cavity'),
                    'sub' => $t('cavities.c2.sub', 'Into the dentin'),
                    'points' => array(
                        $t('cavities.c2.p1', 'The cavity is larger and has reached the dentin'),
                        $t('cavities.c2.p2', 'May be sensitive to hot and cold'),
                        $t('cavities.c2.p3', 'Food gets stuck easily'),
                    ),
                    'treatment' => $t('cavities.c2.tx', 'Larger filling (composite or inlay)'),
                ),
                array(
                    'name' => $t('cavities.c3.name', 'Severe cavity'),
                    'sub' => $t('cavities.c3.sub', 'Close to the pulp'),
                    'points' => array(
                        $t('cavities.c3.p1', 'The cavity is deep and near the nerve'),
                        $t('cavities.c3.p2', 'May cause a noticeable ache'),
                        $t('cavities.c3.p3', 'We evaluate whether a root canal is needed'),
                        $t('cavities.c3.p4', 'A crown may be needed to protect the tooth'),
                    ),
                    'treatment' => $t('cavities.c3.tx', 'Root canal and crown'),
                ),
                array(
                    'name' => $t('cavities.c4.name', 'Pulp inflammation or infection'),
                    'sub' => $t('cavities.c4.sub', 'Pain or swelling'),
                    'points' => array(
                        $t('cavities.c4.p1', 'The cavity has reached the pulp'),
                        $t('cavities.c4.p2', 'Pain can start on its own, or when biting'),
                        $t('cavities.c4.p3', 'Sensitive to hot and cold'),
                        $t('cavities.c4.p4', 'Gums may swell or form an abscess'),
                    ),
                    'treatment' => $t('cavities.c4.tx', 'Root canal and crown'),
                ),
                array(
                    'name' => $t('cavities.c5.name', 'Cannot be saved'),
                    'sub' => $t('cavities.c5.sub', 'Severe damage'),
                    'points' => array(
                        $t('cavities.c5.p1', 'Decay is extensive and most of the tooth structure is gone'),
                        $t('cavities.c5.p2', 'May cause repeated infection and severe pain'),
                        $t('cavities.c5.p3', 'Cannot be repaired with a filling or root canal'),
                    ),
                    'treatment' => $t('cavities.c5.tx', 'Extraction, then an implant, fixed bridge, or removable denture'),
                ),
            ),
        ),

        'gums' => array(
            'id' => 'gum-disease',
            'nav' => $t('gums.nav', 'Gum disease'),
            'title' => $t('gums.title', 'The stages of gum disease'),
            'intro' => $t('gums.intro', 'Gum disease is measured by how deep the pocket between tooth and gum has become, and by how much supporting bone has been lost.'),
            'scale_start' => $t('gums.scale_start', 'Healthy'),
            'scale_end' => $t('gums.scale_end', 'Increasingly severe'),
            'pocket_label' => $t('gums.pocket_label', 'Pocket depth'),
            'signs_label' => $t('stage.signs', 'What you may notice'),
            'stages' => array(
                array(
                    'name' => $t('gums.g1.name', 'Healthy'),
                    'sub' => $t('gums.g1.sub', 'Healthy gums and bone'),
                    'pocket' => '1–3 mm',
                    'depth' => 3,
                    'points' => array(
                        $t('gums.g1.p1', 'Gums are pink and firm'),
                        $t('gums.g1.p2', 'Almost no bleeding'),
                        $t('gums.g1.p3', 'Normal bone height'),
                    ),
                ),
                array(
                    'name' => $t('gums.g2.name', 'Mild periodontitis'),
                    'sub' => $t('gums.g2.sub', 'Early bone loss'),
                    'pocket' => '3–4 mm',
                    'depth' => 4,
                    'points' => array(
                        $t('gums.g2.p1', 'Gums are redder and may bleed when brushing'),
                        $t('gums.g2.p2', 'Tartar is present'),
                        $t('gums.g2.p3', 'Bone loss has begun'),
                    ),
                ),
                array(
                    'name' => $t('gums.g3.name', 'Moderate periodontitis'),
                    'sub' => $t('gums.g3.sub', 'Noticeable bone loss'),
                    'pocket' => '5–6 mm',
                    'depth' => 6,
                    'points' => array(
                        $t('gums.g3.p1', 'Gums are red, swollen, and bleed easily'),
                        $t('gums.g3.p2', 'Obvious tartar, including below the gumline'),
                        $t('gums.g3.p3', 'Noticeable bone loss'),
                        $t('gums.g3.p4', 'Gums may recede'),
                    ),
                ),
                array(
                    'name' => $t('gums.g4.name', 'Severe periodontitis'),
                    'sub' => $t('gums.g4.sub', 'Severe bone loss'),
                    'pocket' => '≥ 7 mm',
                    'depth' => 8,
                    'points' => array(
                        $t('gums.g4.p1', 'Gums are severely red and swollen, and bleed easily'),
                        $t('gums.g4.p2', 'Heavy tartar below the gumline'),
                        $t('gums.g4.p3', 'Severe bone loss and visible gum recession'),
                        $t('gums.g4.p4', 'Teeth may loosen or even fall out'),
                    ),
                ),
            ),
        ),

        'partials' => array(
            'id' => 'partial-dentures',
            'nav' => $t('partials.nav', 'Partial dentures'),
            'title' => $t('partials.title', 'Removable partial dentures compared'),
            'intro' => $t('partials.intro', 'Different materials and different ways of making them. Each has its strengths.'),
            'unit' => $t('unit.each', 'each'),
            'options' => array(
                array(
                    'name' => $t('partials.printed.name', '3D-printed partial denture'),
                    'sub' => $t('partials.printed.sub', 'Digital design, 3D printed'),
                    'price' => '$1,100',
                    'desc' => '',
                    'pros' => array(
                        $t('partials.printed.pro1', 'Designed precisely from a digital scan'),
                        $t('partials.printed.pro2', 'Natural-looking, with no metal'),
                        $t('partials.printed.pro3', 'The most affordable option'),
                        $t('partials.printed.pro4', 'Shorter wait'),
                    ),
                    'cons' => array(
                        $t('partials.printed.con1', 'Not as strong as a metal framework'),
                        $t('partials.printed.con2', 'Not suited to many missing teeth or a heavy bite'),
                        $t('partials.printed.con3', 'Teeth cannot be added later'),
                        $t('partials.printed.con4', 'May wear more easily over time'),
                    ),
                    'specs' => array(
                        array($label_made, $t('partials.printed.made', 'Digital design and 3D printing')),
                        array($label_time, $weeks_short),
                        array($label_looks, $t('level.natural', 'Natural')),
                        array($label_strength, $t('level.medium', 'Medium')),
                        array($label_metal, $t('level.none', 'None')),
                        array($label_add_teeth, $t('level.no', 'No')),
                        array($label_best_for, $t('partials.printed.best', 'Patients on a budget with fewer missing teeth')),
                    ),
                ),
                array(
                    'name' => $t('partials.valplast.name', 'Valplast flexible partial denture'),
                    'sub' => $t('partials.valplast.sub', 'Lab-made flexible resin, no metal'),
                    'price' => '$1,500',
                    'desc' => '',
                    'pros' => array(
                        $t('partials.valplast.pro1', 'No metal, with a natural appearance'),
                        $t('partials.valplast.pro2', 'Flexible material that is comfortable to wear'),
                        $t('partials.valplast.pro3', 'Color close to your gums, hard to notice'),
                    ),
                    'cons' => array(
                        $t('partials.valplast.con1', 'Not as strong as a metal framework'),
                        $t('partials.valplast.con2', 'Not suited to many missing teeth or a heavy bite'),
                        $t('partials.valplast.con3', 'Teeth cannot be added later'),
                        $t('partials.valplast.con4', 'May wear or change shape over time'),
                    ),
                    'specs' => array(
                        array($label_made, $t('partials.valplast.made', 'Handmade by a dental lab in flexible resin')),
                        array($label_time, $weeks_long),
                        array($label_looks, $t('level.very_natural', 'Very natural')),
                        array($label_strength, $t('level.medium', 'Medium')),
                        array($label_metal, $t('level.none', 'None')),
                        array($label_add_teeth, $t('level.no', 'No')),
                        array($label_best_for, $t('partials.valplast.best', 'Patients who want a more natural look')),
                    ),
                ),
                array(
                    'name' => $t('partials.metal.name', 'Metal-framework partial denture'),
                    'sub' => $t('partials.metal.sub', 'Metal framework with acrylic gums and teeth'),
                    'price' => '$1,800',
                    'desc' => '',
                    'pros' => array(
                        $t('partials.metal.pro1', 'Strong, durable metal framework'),
                        $t('partials.metal.pro2', 'Thinner, so it feels more comfortable'),
                        $t('partials.metal.pro3', 'Stable over long-term use'),
                    ),
                    'cons' => array(
                        $t('partials.metal.con1', 'Metal clasps are visible'),
                        $t('partials.metal.con2', 'Higher price'),
                        $t('partials.metal.con3', 'Longer wait'),
                    ),
                    'specs' => array(
                        array($label_made, $t('partials.metal.made', 'Metal framework, acrylic gums, acrylic teeth')),
                        array($label_time, $weeks_long),
                        array($label_looks, $t('level.average', 'Average')),
                        array($label_strength, $t('level.high', 'High')),
                        array($label_metal, $t('partials.metal.metal', 'Yes, metal clasps')),
                        array($label_add_teeth, $t('level.yes', 'Yes')),
                        array($label_best_for, $t('partials.metal.best', 'Patients missing more teeth or needing stronger support')),
                    ),
                ),
            ),
        ),

        'dentures' => array(
            'id' => 'full-dentures',
            'nav' => $t('dentures.nav', 'Full dentures'),
            'title' => $t('dentures.title', 'Full dentures compared'),
            'intro' => $t('dentures.intro', 'The same function, made two different ways. Materials, time, and price differ.'),
            'unit' => $t('unit.each', 'each'),
            'options' => array(
                array(
                    'name' => $t('dentures.printed.name', '3D-printed economy denture'),
                    'sub' => $t('dentures.printed.sub', 'Digital design, 3D printed'),
                    'price' => '$1,200',
                    'desc' => '',
                    'pros' => array(
                        $t('dentures.printed.pro1', 'Designed precisely from a digital scan'),
                        $t('dentures.printed.pro2', 'Tried in before it is finished, for a more comfortable fit'),
                        $t('dentures.printed.pro3', 'Affordable'),
                        $t('dentures.printed.pro4', 'Shorter wait'),
                    ),
                    'cons' => array(
                        $t('dentures.printed.con1', 'Less natural-looking than a traditional denture'),
                        $t('dentures.printed.con2', 'Lower wear resistance; may wear more easily over time'),
                        $t('dentures.printed.con3', 'Fewer shade choices'),
                    ),
                    'specs' => array(
                        array($label_made, $t('dentures.printed.made', 'Digital design and 3D printing')),
                        array($label_time, $weeks_short),
                        array($label_looks, $t('level.average', 'Average')),
                        array($label_durability, $t('level.lower', 'Lower')),
                        array($label_colors, $t('level.fewer', 'Fewer')),
                        array($label_best_for, $t('dentures.printed.best', 'Patients on a budget who are less concerned about appearance')),
                    ),
                ),
                array(
                    'name' => $t('dentures.lab.name', 'Traditional lab-made denture'),
                    'sub' => $t('dentures.lab.sub', 'Handcrafted by a dental technician'),
                    'price' => '$1,800',
                    'desc' => '',
                    'pros' => array(
                        $t('dentures.lab.pro1', 'Handcrafted by a professional dental technician'),
                        $t('dentures.lab.pro2', 'More natural, more attractive appearance'),
                        $t('dentures.lab.pro3', 'More choices of shade and tooth shape'),
                        $t('dentures.lab.pro4', 'Stronger and more durable'),
                    ),
                    'cons' => array(
                        $t('dentures.lab.con1', 'Higher price'),
                        $t('dentures.lab.con2', 'Longer wait'),
                        $t('dentures.lab.con3', 'Several adjustment visits are needed'),
                        $t('dentures.lab.con4', 'Repairs may take longer'),
                    ),
                    'specs' => array(
                        array($label_made, $t('dentures.lab.made', 'Handcrafted by a dental technician')),
                        array($label_time, $weeks_long),
                        array($label_looks, $t('level.better', 'Better, more natural')),
                        array($label_durability, $t('level.higher', 'Higher')),
                        array($label_colors, $t('level.more', 'More')),
                        array($label_best_for, $t('dentures.lab.best', 'Patients who place a higher priority on appearance, comfort, and durability')),
                    ),
                ),
            ),
        ),
    );
}

/**
 * Flat price list derived from the guides, for the at-a-glance table.
 */
function simple_dental_get_treatment_price_list($guides) {
    $groups = array();

    foreach (array('crowns', 'partials', 'dentures') as $guide_key) {
        if (empty($guides[$guide_key]['options'])) {
            continue;
        }

        $rows = array();
        foreach ($guides[$guide_key]['options'] as $option) {
            $rows[] = array(
                'name' => $option['name'],
                'price' => $option['price'],
            );
        }

        $groups[] = array(
            'id' => $guides[$guide_key]['id'],
            'title' => $guides[$guide_key]['nav'],
            'unit' => $guides[$guide_key]['unit'],
            'rows' => $rows,
        );
    }

    return $groups;
}

/**
 * Render a 1–5 rating as pips with a text alternative.
 */
function simple_dental_render_guide_rating($score) {
    $score = max(0, min(5, (int) $score));
    $label = sprintf(simple_dental_guide_t('rating', '%d of 5'), $score);

    $html = '<span class="tg-rating" role="img" aria-label="' . esc_attr($label) . '">';
    for ($i = 1; $i <= 5; $i++) {
        $html .= '<span class="tg-rating__pip' . ($i <= $score ? ' is-on' : '') . '"></span>';
    }
    $html .= '</span>';

    return $html;
}

/**
 * Render a side-by-side option comparison (crowns, partials, dentures).
 */
function simple_dental_render_guide_options($guide) {
    $count = count($guide['options']);
    $pros_label = simple_dental_guide_t('option.pros', 'Advantages');
    $cons_label = simple_dental_guide_t('option.cons', 'Trade-offs');

    $has_desc = !empty($guide['options'][0]['desc']);

    $spec_count = count($guide['options'][0]['specs']);
    $row_count = ($has_desc ? 5 : 4) + $spec_count;

    echo '<div class="tg-options tg-options--' . (int) $count . '" style="--tg-rows: ' . (int) $row_count . '; --tg-spec-rows: ' . (int) $spec_count . ';" tabindex="0" role="group" aria-label="' . esc_attr($guide['title']) . '">';

    foreach ($guide['options'] as $option) {
        echo '<article class="tg-option">';
        echo '<header class="tg-option__head">';
        echo '<h3 class="tg-option__name">' . esc_html($option['name']) . '</h3>';
        echo '<p class="tg-option__sub">' . esc_html($option['sub']) . '</p>';
        echo '</header>';

        echo '<p class="tg-option__price"><span class="tg-option__amount">' . esc_html($option['price']) . '</span> <span class="tg-option__unit">' . esc_html($guide['unit']) . '</span></p>';

        if ($has_desc) {
            echo '<p class="tg-option__desc">' . esc_html($option['desc']) . '</p>';
        }

        echo '<div class="tg-option__list">';
        echo '<h4 class="tg-option__label">' . esc_html($pros_label) . '</h4>';
        echo '<ul class="tg-list tg-list--pros">';
        foreach ($option['pros'] as $item) {
            echo '<li>' . esc_html($item) . '</li>';
        }
        echo '</ul></div>';

        echo '<div class="tg-option__list">';
        echo '<h4 class="tg-option__label">' . esc_html($cons_label) . '</h4>';
        echo '<ul class="tg-list tg-list--cons">';
        foreach ($option['cons'] as $item) {
            echo '<li>' . esc_html($item) . '</li>';
        }
        echo '</ul></div>';

        echo '<dl class="tg-specs">';
        foreach ($option['specs'] as $spec) {
            echo '<div class="tg-specs__row"><dt>' . esc_html($spec[0]) . '</dt><dd>';
            echo is_int($spec[1]) ? simple_dental_render_guide_rating($spec[1]) : esc_html($spec[1]);
            echo '</dd></div>';
        }
        echo '</dl>';

        echo '</article>';
    }

    echo '</div>';
}
