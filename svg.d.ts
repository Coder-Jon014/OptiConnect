// resources/js/svg.d.ts
declare module '*.svg?react' {
    const content: React.FC<React.SVGProps<SVGSVGElement>>;
    export default content;
  }
  
  declare module '*.svg' {
    const content: string;
    export default content;
  }
  