from http.server import SimpleHTTPRequestHandler, ThreadingHTTPServer
from pathlib import Path
from urllib.parse import unquote, urlparse

ROOT = Path(__file__).resolve().parent

class SPAHandler(SimpleHTTPRequestHandler):
    def translate_path(self, path):
        relative = unquote(urlparse(path).path).lstrip('/')
        candidate = (ROOT / relative).resolve()
        if ROOT not in candidate.parents and candidate != ROOT:
            return str(ROOT / 'index.html')
        if candidate.exists():
            return str(candidate)
        return str(ROOT / 'index.html')

    def log_message(self, format, *args):
        print('%s - %s' % (self.address_string(), format % args), flush=True)

if __name__ == '__main__':
    ThreadingHTTPServer(('0.0.0.0', 3000), SPAHandler).serve_forever()
