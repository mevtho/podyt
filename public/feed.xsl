<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"
    xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
    xmlns:itunes="http://www.itunes.com/dtds/podcast-1.0.dtd">
<xsl:output method="html" encoding="UTF-8" indent="yes"/>

<xsl:template match="/rss/channel">
<html lang="{language}">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<title><xsl:value-of select="title"/></title>
<xsl:if test="itunes:image/@href or image/url">
  <link rel="icon" href="{itunes:image/@href | image/url}"/>
  <link rel="apple-touch-icon" href="{itunes:image/@href | image/url}"/>
</xsl:if>
<style>
  :root {
    color-scheme: light dark;
    --bg: #f5f5f7;
    --card-bg: #ffffff;
    --text: #1c1c1e;
    --muted: #6e6e73;
    --accent: #6f42c1;
    --border: #e5e5ea;
  }
  @media (prefers-color-scheme: dark) {
    :root {
      --bg: #000000;
      --card-bg: #1c1c1e;
      --text: #f2f2f7;
      --muted: #98989d;
      --accent: #a077f0;
      --border: #2c2c2e;
    }
  }
  * { box-sizing: border-box; -webkit-tap-highlight-color: transparent; }
  body {
    margin: 0;
    padding: 0 env(safe-area-inset-right) env(safe-area-inset-bottom) env(safe-area-inset-left);
    background: var(--bg);
    color: var(--text);
    font-family: -apple-system, BlinkMacSystemFont, "SF Pro Text", Helvetica, Arial, sans-serif;
    -webkit-text-size-adjust: 100%;
  }
  header {
    display: flex;
    gap: 16px;
    align-items: center;
    padding: 20px 16px;
    padding-top: calc(20px + env(safe-area-inset-top));
  }
  header img {
    width: 88px;
    height: 88px;
    border-radius: 18px;
    object-fit: cover;
    box-shadow: 0 2px 10px rgba(0,0,0,0.2);
    flex-shrink: 0;
  }
  header .meta { min-width: 0; }
  header h1 {
    font-size: 20px;
    margin: 0 0 4px 0;
    line-height: 1.25;
  }
  header .byline {
    font-size: 14px;
    color: var(--muted);
    margin: 0 0 6px 0;
  }
  header .desc {
    font-size: 13px;
    color: var(--muted);
    margin: 0;
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
  }
  .notice {
    margin: 0 16px 16px 16px;
    padding: 10px 12px;
    background: var(--card-bg);
    border: 1px solid var(--border);
    border-radius: 10px;
    font-size: 12px;
    color: var(--muted);
  }
  ul.episodes {
    list-style: none;
    margin: 0;
    padding: 0 16px 32px 16px;
    display: flex;
    flex-direction: column;
    gap: 10px;
  }
  li.episode {
    background: var(--card-bg);
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 14px 16px;
  }
  .episode h2 {
    font-size: 16px;
    margin: 0 0 4px 0;
    line-height: 1.3;
  }
  .episode .sub {
    font-size: 12px;
    color: var(--muted);
    margin: 0 0 10px 0;
  }
  .episode .sub .dot {
    margin: 0 5px;
  }
  .episode .summary {
    font-size: 13px;
    color: var(--muted);
    margin: 0 0 10px 0;
  }
  audio {
    width: 100%;
    height: 32px;
  }
  .episode.qa {
    padding: 16px;
  }
  .qa-label {
    font-size: 11px;
    font-weight: 600;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    color: var(--accent);
    margin: 0 0 6px 0;
  }
  .qa-question {
    font-size: 17px;
    font-weight: 600;
    line-height: 1.35;
    margin: 0 0 10px 0;
  }
  .qa-answer {
    font-size: 15px;
    line-height: 1.6;
    margin: 0 0 12px 0;
    white-space: pre-line;
  }
  .qa-source {
    font-size: 12px;
    color: var(--muted);
    margin: 0 0 4px 0;
  }
</style>
</head>
<body>
  <header>
    <xsl:if test="itunes:image/@href or image/url">
      <img src="{itunes:image/@href | image/url}" alt=""/>
    </xsl:if>
    <div class="meta">
      <h1><xsl:value-of select="title"/></h1>
      <p class="byline"><xsl:value-of select="itunes:author"/></p>
      <xsl:if test="itunes:summary">
        <p class="desc"><xsl:value-of select="itunes:summary"/></p>
      </xsl:if>
    </div>
  </header>

  <xsl:choose>
    <xsl:when test="item/enclosure/@url != ''">
      <p class="notice">This is a podcast RSS feed. Bookmark this page to check for new episodes, or paste this URL into a podcast app to subscribe.</p>
    </xsl:when>
    <xsl:otherwise>
      <p class="notice">These are answers generated from your videos. Bookmark this page to check back for new ones, or paste this URL into a feed reader to subscribe.</p>
    </xsl:otherwise>
  </xsl:choose>

  <ul class="episodes">
    <xsl:for-each select="item">
      <xsl:choose>
        <xsl:when test="enclosure/@url != ''">
          <li class="episode">
            <h2><xsl:value-of select="title"/></h2>
            <p class="sub">
              <xsl:value-of select="substring(pubDate, 6, 11)"/>
              <xsl:if test="itunes:duration">
                <span class="dot">&#183;</span>
                <xsl:value-of select="itunes:duration"/>
              </xsl:if>
            </p>
            <xsl:if test="itunes:summary">
              <p class="summary"><xsl:value-of select="itunes:summary"/></p>
            </xsl:if>
            <audio controls="controls" preload="none">
              <source src="{enclosure/@url}"/>
            </audio>
          </li>
        </xsl:when>
        <xsl:otherwise>
          <li class="episode qa">
            <p class="qa-label">Question</p>
            <h2 class="qa-question">
              <xsl:choose>
                <xsl:when test="itunes:subtitle"><xsl:value-of select="itunes:subtitle"/></xsl:when>
                <xsl:otherwise><xsl:value-of select="title"/></xsl:otherwise>
              </xsl:choose>
            </h2>
            <xsl:if test="itunes:summary">
              <p class="qa-answer"><xsl:value-of select="itunes:summary"/></p>
            </xsl:if>
            <xsl:if test="itunes:subtitle and itunes:subtitle != title">
              <p class="qa-source">From &#8220;<xsl:value-of select="title"/>&#8221;</p>
            </xsl:if>
            <p class="sub"><xsl:value-of select="substring(pubDate, 6, 11)"/></p>
          </li>
        </xsl:otherwise>
      </xsl:choose>
    </xsl:for-each>
  </ul>
</body>
</html>
</xsl:template>

</xsl:stylesheet>
