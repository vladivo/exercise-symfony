import {Directive, ViewContainerRef} from '@angular/core';

@Directive({ selector: '[appEntityHost]' })
export class EntityHostDirective {
  constructor(public readonly viewContainerRef: ViewContainerRef) {}
}
