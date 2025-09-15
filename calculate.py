#!/usr/bin/env python3
# -*- coding: utf-8 -*-

import sys
import html

def parse_args():
    if len(sys.argv) != 4:
        print("<div class='error'>Usage: calculate.py a b c (3 numbers)</div>")
        sys.exit(0)
    try:
        a = float(sys.argv[1])
        b = float(sys.argv[2])
        c = float(sys.argv[3])
        return a, b, c
    except ValueError:
        print("<div class='error'>Please provide valid numbers for a, b, c.</div>")
        sys.exit(0)

def compute(a, b, c):
    if a == 0:
        raise ZeroDivisionError("a must not be 0 (division by zero).")
    c_cubed = c ** 3
    sqrt_c_cubed = c_cubed ** 0.5
    division = sqrt_c_cubed / a
    multiplied = division * 10
    result = multiplied + b
    return c_cubed, sqrt_c_cubed, division, multiplied, result

def main():
    try:
        a, b, c = parse_args()
        c3, sqrtc3, div, mult, res = compute(a, b, c)
        print(f"""
<div class="result">
  <h2>Calculation Result</h2>
  <ul>
    <li>Inputs: a={a}, b={b}, c={c}</li>
    <li>c^3 = {c3}</li>
    <li>sqrt(c^3) = {sqrtc3}</li>
    <li>sqrt(c^3) / a = {div}</li>
    <li>×10 = {mult}</li>
    <li><strong>Final result = {res}</strong></li>
  </ul>
</div>
""")
    except Exception as e:
        print(f"<div class='error'>Error: {html.escape(str(e))}</div>")

if __name__ == "__main__":
    main()
