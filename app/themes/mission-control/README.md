# Apollo — Mission Control

### Functions
TK

### Styles

#### Basic Concepts
Unlike most frameworks, there are no set styles. For starters each configurable element will give you the bare necessities to build upon.

For Example: The `.btn` class will give you all the basic properities of a button. Adding the `@include btn-styler()` mixin to any custom button class will give you full range to build your own as-needed.

#### Buttons
Just the basics for starters but get as fancy as you'd like with the `.btn-styler` mixin.

```html
<a class="btn" href="#">OG Button Link</a>
<a class="btn btn-default" href="#">Default</a>
<a class="btn btn-simple" href="#">Simple</a>
<a class="btn btn-kitchen-sink" href="#">Kitchen Sink</a>
```

```scss
// Base
.btn {
  @extend %btn;
}

// Most Basic
.btn-default {
  @include button-styler;
}

// Simple Variation
.btn-simple {
  @include button-styler($background: orange);
}

// Kitchen Sink Example
.btn-kitchen-sink {
  @include button-styler(
    $padding: 20px 30px,
    $color: white,
    $background: crimson,
    $border: 2px dashed black,

    // Hover
    $hover-color: maroon,
    $hover-background: lightblue,
    $hover-border: 4px dotted crimson,
    $font-weight: 900,

    // Focus
    $focus-color: red,
    $focus-background: yellow,
    $focus-border: 4px dotted beige,

    // Active
    $active-color: green,
    $active-background: blue,
    $active-border: 4px dotted purple,

    // Visited
    $visited-color: brown,
    $visited-background: gold,
    $visited-border: 4px dotted dodgerblue
  );
}
```
