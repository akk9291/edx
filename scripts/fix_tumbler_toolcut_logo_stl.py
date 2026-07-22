#!/usr/bin/env python3
"""
Fix visibility of the lower 'logo' band in combined toolcut STLs.

The mesh from many CAD exports is coplanar / flush with the tumbler body shell, so in
Three.js (and other viewers) it z-fights and looks like a faint smudge. This script
radially offsets the bottom disconnected component by a few tenths of a millimetre so
it sits slightly outside the body surface.

Usage:
  python3 scripts/fix_tumbler_toolcut_logo_stl.py [input.stl] [output-dir]

Default input path can be overridden with env TUMBLER_TOOLCUT_STL.
"""
from __future__ import annotations

import os
import sys

import numpy as np

try:
    import trimesh
except ImportError as e:
    raise SystemExit("Install trimesh: pip install trimesh numpy") from e

# Matches customize-app.js parse transform (body STL is centred here in mm space).
AXIS_CX = 48.5
AXIS_CY = 48.5
DEFAULT_RADIAL_OFFSET_MM = 0.45
# Slight axial separation for horizontal caps (reduces fighting with boot/body).
CAP_Z_PUSH_MM = 0.2


def radial_offset_vertices(vertices: np.ndarray, offset_mm: float) -> np.ndarray:
    v = np.array(vertices, dtype=np.float64, copy=True)
    dx = v[:, 0] - AXIS_CX
    dy = v[:, 1] - AXIS_CY
    r = np.sqrt(dx * dx + dy * dy)
    mask = r > 1e-4
    scale = (r[mask] + offset_mm) / r[mask]
    v[mask, 0] = AXIS_CX + dx[mask] * scale
    v[mask, 1] = AXIS_CY + dy[mask] * scale
    return v


def push_cap_vertices_z(vertices: np.ndarray, z_lo: float, z_hi: float, eps: float) -> np.ndarray:
    v = vertices
    tol = 0.05
    lo = v[:, 2] < z_lo + tol
    hi = v[:, 2] > z_hi - tol
    v = v.copy()
    v[lo, 2] -= eps
    v[hi, 2] += eps
    return v


def main() -> int:
    default_in = os.environ.get(
        "TUMBLER_TOOLCUT_STL",
        "/Users/mousamjain/Library/Containers/net.whatsapp.WhatsApp/Data/tmp/documents/"
        "BA8B3D3D-8A69-4B4B-8640-B586410F65F2/tumbler 1200ml TOOLCUT AND LOGO.STL",
    )
    in_path = sys.argv[1] if len(sys.argv) > 1 else default_in
    out_dir = sys.argv[2] if len(sys.argv) > 2 else os.path.join(
        os.path.dirname(os.path.dirname(os.path.abspath(__file__))),
        "public",
        "assets",
        "models",
        "tumbler-1200ml-parts",
    )

    if not os.path.isfile(in_path):
        print("Input STL not found:", in_path, file=sys.stderr)
        return 1

    mesh = trimesh.load(in_path, force="mesh")
    if not isinstance(mesh, trimesh.Trimesh):
        print("Expected a single mesh STL.", file=sys.stderr)
        return 1

    parts = mesh.split(only_watertight=False)
    if len(parts) < 2:
        print(
            "Only one connected component; nothing to split. "
            "Radial offset applied to whole mesh.",
            file=sys.stderr,
        )
        parts = [mesh]

    # Lowest component by Z (bottom band / 'logo' tool path in your file).
    parts_sorted = sorted(parts, key=lambda p: float(p.bounds[0, 2]))
    bottom = parts_sorted[0]
    rest = parts_sorted[1:]

    z0, z1 = float(bottom.bounds[0, 2]), float(bottom.bounds[1, 2])
    v = radial_offset_vertices(bottom.vertices, DEFAULT_RADIAL_OFFSET_MM)
    v = push_cap_vertices_z(v, z0, z1, CAP_Z_PUSH_MM)
    bottom = trimesh.Trimesh(vertices=v, faces=bottom.faces, process=False)

    logo_only = os.path.join(out_dir, "logo-from-toolcut-fixed.stl")
    combined = os.path.join(out_dir, "tumbler-toolcut-and-logo-fixed.stl")
    ring_only = os.path.join(out_dir, "ring-from-toolcut.stl")

    os.makedirs(out_dir, mode=0o755, exist_ok=True)
    bottom.export(logo_only)
    if rest:
        ring_mesh = trimesh.util.concatenate(rest)
        ring_mesh.export(ring_only)
        trimesh.util.concatenate([bottom] + rest).export(combined)
    else:
        bottom.export(combined)

    print("Wrote:", logo_only)
    if rest:
        print("Wrote:", ring_only)
        print("Wrote:", combined)
    print(
        "Note: This STL has no triangle mesh for the letters 'perch' — only the lower "
        "toolcut band and upper ring. For real lettering you must export embossed text "
        "as geometry from CAD or use a texture / engraving layer in the app."
    )
    return 0


if __name__ == "__main__":
    raise SystemExit(main())
