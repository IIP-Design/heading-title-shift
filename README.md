# IIP Second Author for WordPress

This plugin provides backend support to add a second author to a WordPress post. It will add the following metabox to the the post admin area:

![Screenshot of metabox added by plugin](metabox_screenshot.png)

The plugin defaults this option to `No`, meaning no second author is added to the post. When the `Yes` option is selected a standard WordPress author dropdown will appear (once the post is saved). Here any author registered on the site can be select as the second author for the post.

The plugin will subsequently add two custom fields to the post metavalues:

| Metafield                 | Value                                          |
|---------------------------|------------------------------------------------|
| `_iip_add_second_author`  | string: `no` or `yes` based on radio selection |
| `_iip_post_second_author` | string: ID of the selected user                |

## Theme Support

This plugin simply adds two additional fields to a post's metadata. It will not display those values on the front end out of the box. In order to display these fields you will need to add a few lines to the relevant site's theme. We suggest something like:

```
$second_author_value = get_post_meta( $this->post->ID, "_iip_add_second_author", true );
$second_author_id = get_post_meta( $this->post->ID, "_iip_post_second_author", true );
$second_author_name = get_userdata( $second_author_id )->display_name;
$second_author_url = get_author_posts_url( $second_author_id );
$second_author_line = ( $second_author_value == 'yes' ) ? '| <a href="' . $second_author_url . '">' . $second_author_name . '</a>' : '';
```

The above code snippet will create a variable `$second_author_line`. If the add second author metabox is set to `yes`, this variable will produce an element displaying the second author's name and linked to their author profile (otherwise it'll generate an empty string). This variable, can then be inserted where the theme generates a byline.