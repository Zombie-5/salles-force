@extends('app.layouts.basico')

@section('conteudo')
    <div class="conteudo-pagina">
        <div class="grid-links">
            <section class="myCard-links">
                <h2 class="subtitulo-pagina">Grupos de Comunidade</h2>
                <ul class="lista-links">
                    <li>
                        <a href="https://chat.whatsapp.com/EafBNZ80zrhFzHw17QTtxq" class="link-social whatsapp">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path
                                    d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z">
                                </path>
                            </svg>
                            Grupo WhatsApp
                        </a>
                    </li>
                    <li>
                        <a href="https://t.me/+x1zhInu6ouQ3M2U0" class="link-social telegram">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="22" y1="2" x2="11" y2="13"></line>
                                <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                            </svg>
                            Grupo Telegram
                        </a>
                    </li>
                </ul>
            </section>

            <section class="myCard-links">
                <h2 class="subtitulo-pagina">Fale com um Assistente</h2>
                <ul class="lista-links">
                    <li>
                        <a href="https://wa.me/244953623511" class="link-social whatsapp">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path
                                    d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z">
                                </path>
                            </svg>
                            Assistente WhatsApp
                        </a>
                    </li>
                    <li>
                        <a href="https://t.me/sallesforce_one1" class="link-social telegram">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="22" y1="2" x2="11" y2="13"></line>
                                <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                            </svg>
                            Assistente Telegram
                        </a>
                    </li>

                    <li>
                        <a href="https://wa.me/244950866654" class="link-social whatsapp">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path
                                    d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z">
                                </path>
                            </svg>
                            Gerente de Promoção
                        </a>
                    </li>
                </ul>
            </section>
        </div>
    </div>

    <style>
        .grid-links {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1rem;
        }

        .myCard-links {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
        }

        .subtitulo-pagina {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: #444;
        }

        .lista-links {
            list-style-type: none;
            padding: 0;
        }

        .lista-links li {
            margin-bottom: 1rem;
        }

        .link-social {
            display: flex;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }

        .link-social.whatsapp {
            background-color: #25D366;
            color: #fff;
        }

        .link-social.telegram {
            background-color: #0088cc;
            color: #fff;
        }

        .link-social:hover {
            opacity: 0.9;
        }

        .icon {
            width: 24px;
            height: 24px;
            margin-right: 0.75rem;
            color: white;
        }

        @media (max-width: 768px) {
            .conteudo-pagina {
                padding: 1rem;
            }

            .grid-links {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endsection
