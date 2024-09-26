<!DOCTYPE html>
<html lang="fr">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Pantheons - Battle of Gods</title>

		<link rel="stylesheet" href="../../css/main.css"/>
		<link rel="stylesheet" href="../../css/_custom.scss"/>
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
	</head>

	<body>

		<canvas id="neuro"></canvas>
		
        <header>
            <nav class="navbar navbar-dark p-2">
                <div class="container-fluid grid gap-3">
                    <a class="navbar-brand order-last g-col-6 text-center" href="/"><img class="img-fluid" src="/ressources/brand/logo.png" alt="logo"></a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="offcanvas offcanvas-sm offcanvas-start g-col-3" tabindex="-1" id="offcanvasDarkNavbar" style="font-family: 'Dalek'; text-shadow: #ffffff 1px 0 10px; width: fit-content; background-color: #7BDBF4 !important;">
                        <div class="home-button" style="position: absolute; padding-top: 1rem; padding-left: 1.5rem; color: white;">
                            <a class="light-linklink-underline link-underline-opacity-0 text-white" href="/"><i class="bi bi-house-door-fill" style="font-size: 20px"></i></a>
                        </div>
                        <div class="offcanvas-header" style="display: initial; display: flex;">
                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close" style="padding-top: 1.4rem; padding-right: 2rem;"></button>
                        </div>
                        <div class="offcanvas-body" style="padding: 2rem;">
                            <ul class="navbar-nav flex-grow-1">
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="/">Accueil</a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="/Pantheons" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Découvrir les pantheons
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-dark">
                                        <li><a class="dropdown-item" href="/Pantheons-Grec">Pantheon Grec</a></li>
                                        <li><a class="dropdown-item" href="/Pantheons-Meso">Pantheon Mésopotamien</a></li>
                                        <li><a class="dropdown-item" href="/Pantheons-Egypt">Pantheon Égyptien</a></li>
                                        <li><a class="dropdown-item" href="/Pantheons-Slave">Pantheon Slave</a></li>
                                    </ul>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="/MAJ">Mises à jour</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="/FAQ">FAQ</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="/Boutique">Boutique</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="/contact">Nous contacter</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="g-col-3 order-last">
                        <button class="btn btn-outline-light bi bi-search"></button>
                    </div>
                </div>	
            </nav>
        </header>

		<main role="main">
			
		</main>

		
		<footer class="bg-black text-white text-center footer" style="--bs-bg-opacity: .3;">
			<div class="row">
				<div class="col-4"></div>
				<div class="col-4 pt-3">
					<p class="text-center">&copy;
						Ekuaedé Editions
					</p>
				</div>
				<div class="col-2"></div>
				<div class="col-2">
					<i class="bi bi-instagram" style="font-size: 32px; color: white; padding-right: 10%;"></i>
					<i class="bi bi-facebook" style="font-size: 32px; color: white;"></i>
				</div>
			</div>
		</footer>


		<script type="x-shader/x-fragment" id="vertShader">
			precision mediump float;
		
			varying vec2 vUv;
			attribute vec2 a_position;
		
			void main() {
				vUv = .5 * (a_position + 1.);
				gl_Position = vec4(a_position, 0.0, 1.0);
			}
		</script>
	
		<script type="x-shader/x-fragment" id="fragShader">
			precision mediump float;
		
			varying vec2 vUv;
			uniform float u_time;
			uniform float u_ratio;
			uniform vec2 u_pointer_position;
			uniform float u_scroll_progress;
		
			vec2 rotate(vec2 uv, float th) {
				return mat2(cos(th), sin(th), -sin(th), cos(th)) * uv;
			}
		
			float neuro_shape(vec2 uv, float t, float p) {
				vec2 sine_acc = vec2(0.);
				vec2 res = vec2(0.);
				float scale = 8.;
		
				for (int j = 0; j < 15; j++) {
					uv = rotate(uv, 1.);
					sine_acc = rotate(sine_acc, 1.);
					vec2 layer = uv * scale + float(j) + sine_acc - t;
					sine_acc += sin(layer);
					res += (.5 + .5 * cos(layer)) / scale;
					scale *= (1.2 - .07 * p);
				}
				return res.x + res.y;
			}
		
			void main() {
				vec2 uv = .5 * vUv;
				uv.x *= u_ratio;
		
				vec2 pointer = vUv - u_pointer_position;
				pointer.x *= u_ratio;
				float p = clamp(length(pointer), 0., 1.);
				p = .5 * pow(1. - p, 2.);
		
				float t = .001 * u_time;
				vec3 color = vec3(0.);
		
				float noise = neuro_shape(uv, t, p);
		
				noise = 1.2 * pow(noise, 3.);
				noise += pow(noise, 10.);
				noise = max(.0, noise - .5);
				noise *= (1. - length(vUv - .5));
		
				color = normalize(vec3(.2, .5 + .4 * cos(3. * u_scroll_progress), .5 + .5 * sin(3. * u_scroll_progress)));
		
				color = color * noise;
		
				gl_FragColor = vec4(color, noise);
			}
		</script>

		<script src="../../js/app.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
	</body>

</html>
