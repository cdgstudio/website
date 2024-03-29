<?php

namespace CG\Integrations\Acf\Blocks\CodePreview;

use CG\Integrations\Acf\AcfIntegration;
use WP_Block_Type_Registry;

class CodePreviewBlock
{
    public const NAME = 'acf/code-preview';

    public function __construct()
    {
        add_action('acf/init', array($this, 'register_block'));
        add_filter('allowed_block_types_all', array($this, 'remove_code_block'));
        add_action('save_post', array($this, 'remove_cache'));

        new CodePreviewCron();
    }

    public function register_block(): void
    {
        acf_register_block_type(
            array(
                'name' => 'code_preview',
                'title' => __('Code preview', 'cg'),
                'description' => __('A custom testimonial block.', 'cg'),
                'render_template' => AcfIntegration::get_template_path_by_class_name(self::class),
                'enqueue_style' => AcfIntegration::get_style_uri_by_class_name(self::class),
                'enqueue_script' => AcfIntegration::get_script_uri_by_class_name(self::class),
                'mode' => 'preview',
                'category' => 'formatting',
                'icon' => 'admin-comments',
                'keywords' => array(),
            )
        );
    }

    public function remove_code_block($allowed_blocks): array
    {
        $instance = WP_Block_Type_Registry::get_instance();
        $instance->unregister('core/code');
        return array_keys($instance->get_all_registered());
    }

    public function remove_cache($post_id)
    {
        if (defined("DOING_CRON") && DOING_CRON) {
            return;
        }

        $post_content = get_the_content(null, false, $post_id);
        $has_block = has_block(self::NAME, $post_content);
        if (false === $has_block) {
            return;
        }

        $parsed = parse_blocks($post_content);
        foreach ($parsed as &$block) {
            $this->format_and_highlight_block($block);
        }

        $new_post_content = serialize_blocks($parsed);

        remove_action('save_post', array($this, 'remove_cache'));
        remove_action('post_updated', 'wp_save_post_revision');

        wp_update_post(
            array(
                'ID' => $post_id,
                'post_content' => wp_slash($new_post_content),
            )
        );

        add_action('post_updated', 'wp_save_post_revision');
        add_action('save_post', array($this, 'remove_cache'));
    }

    private function format_and_highlight_block(mixed &$block): void
    {
        foreach ($block['innerBlocks'] as &$innerBlock) {
            $this->format_and_highlight_block($innerBlock);
        }

        if ($block['blockName'] === self::NAME) {
            $block['attrs']['data']['E3CBDF3F888B1896576C840F04586E24'] = '';
        }

    }

}

