import os
import re

path = r"c:\Users\Amine mokrane\OneDrive - Aston University\Desktop\myApp 1\myApp\public\css\style.css"

with open(path, 'r', encoding='utf-8') as f:
    content = f.read()

# Unified Design Tokens
root_vars = """:root {
    --accent:          #32FF7E;
    --accent-dark:     #22cc62;
    --accent-glow:     rgba(50, 255, 126, 0.35);

    --bg-color:        #ffffff;
    --bg-rgb:          255, 255, 255;
    --bg-secondary:    #f7f7f7;
    --card-bg:         #f2f2f2;

    --text-primary:    #111111;
    --text-secondary:  #555555;
    --text-muted:      #999999;

    --footer-bg:       #f5f5f5;
    --footer-text:     #444444;

    --side-menu-bg:    rgba(220, 220, 220, 0.95);
    --icon-bg:         #32FF7E;

    --radius-sm:       8px;
    --radius-md:       16px;
    --radius-lg:       24px;
    --radius-xl:       32px;

    --shadow-card:     0 4px 24px rgba(0,0,0,0.08);
    --shadow-hover:    0 12px 40px rgba(0,0,0,0.14);
    --shadow-accent:   0 0 25px rgba(50, 255, 126, 0.5);

    /* Legacy compatibility */
    --text-color1:     #111111;
    --text-color2:     #555555;
}"""

dark_vars = """body.dark-mode {
    --bg-color:        #111111;
    --bg-rgb:          17, 17, 17;
    --bg-secondary:    #1a1a1a;
    --card-bg:         #1e1e1e;

    --text-primary:    #f0f0f0;
    --text-secondary:  #aaaaaa;
    --text-muted:      #666666;

    --footer-bg:       #0d0d0d;
    --footer-text:     #888888;

    --side-menu-bg:    rgba(20, 20, 20, 0.97);
    --icon-bg:         rgba(0,0,0,0);
    
    --shadow-card:     0 4px 24px rgba(0,0,0,0.4);
    --shadow-hover:    0 12px 40px rgba(0,0,0,0.6);

    /* Legacy compatibility */
    --text-color1:     #f0f0f0;
    --text-color2:     #aaaaaa;
}"""

# Replace :root - we match multiline and dotall
content = re.sub(r':root\s*\{[^}]*\}', root_vars, content, flags=re.MULTILINE|re.DOTALL)
# Replace body.dark-mode - we match multiline and dotall
content = re.sub(r'body\.dark-mode\s*\{[^}]*\}', dark_vars, content, flags=re.MULTILINE|re.DOTALL)

with open(path, 'w', encoding='utf-8', newline='') as f:
    f.write(content)

print("Styles updated successfully.")
